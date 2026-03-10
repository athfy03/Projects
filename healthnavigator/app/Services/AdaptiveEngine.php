<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AdaptiveEngine
{
    private float $stopTopProb = 0.80;
    private int $maxQuestions = 12;

    public function startSession(): int
    {
        return DB::transaction(function () {
            $sessionId = DB::table('assessment_sessions')->insertGetId([
                'status' => 'in_progress',
                'question_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Priors across ALL conditions
            $conditions = DB::table('conditions')->select('id', 'prior')->get();
            $sum = (float)($conditions->sum('prior') ?: 1.0);

            foreach ($conditions as $c) {
                DB::table('session_posteriors')->insert([
                    'assessment_session_id' => $sessionId,
                    'condition_id' => $c->id,
                    'prob' => ((float)$c->prior) / $sum,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return $sessionId;
        });
    }

    public function getState(int $sessionId): array
    {
        $this->ensureSessionExists($sessionId);

        $posterior = $this->posteriorMap($sessionId);
        $top3 = $this->topN($sessionId, 3);

        $askedQIds = DB::table('session_answers')
            ->where('assessment_session_id', $sessionId)
            ->orderBy('id')
            ->pluck('question_id')
            ->all();

        $canBack = count($askedQIds) > 0;

        // Early stop: if only answered "feeling=good"
        if (count($askedQIds) === 1) {
            $last = $this->lastAnswer($sessionId);
            if ($last) {
                $code = DB::table('questions')->where('id', $last->question_id)->value('code');
                if ($code === 'feeling' && $last->answer_value === 'good') {
                    return [
                        'should_stop' => true,
                        'next_question' => null,
                        'next_options' => [],
                        'top3' => $top3,
                        'can_back' => $canBack,
                    ];
                }
            }
        }

        if ($this->shouldStop($sessionId, $posterior)) {
            return [
                'should_stop' => true,
                'next_question' => null,
                'next_options' => [],
                'top3' => $top3,
                'can_back' => $canBack,
            ];
        }

        // Forced early flow: feeling -> duration
        if (!$canBack) {
            $qid = $this->qid('feeling');
            if ($qid) return $this->questionPayload($qid, $top3, $canBack);
        }

        if ($this->hasAsked($sessionId, 'feeling') && !$this->hasAsked($sessionId, 'duration')) {
            $qid = $this->qid('duration');
            if ($qid) return $this->questionPayload($qid, $top3, $canBack);
        }

        // Info gain pick
        $nextQId = $this->pickNextQuestion($sessionId, $posterior, $askedQIds);
        if (!$nextQId) {
            return [
                'should_stop' => true,
                'next_question' => null,
                'next_options' => [],
                'top3' => $top3,
                'can_back' => $canBack,
            ];
        }

        return $this->questionPayload($nextQId, $top3, $canBack);
    }

    public function submitAnswer(int $sessionId, int $questionId, string $answerValue): void
    {
        $this->ensureSessionExists($sessionId);

        $opt = DB::table('question_options')
            ->where('question_id', $questionId)
            ->where('value', $answerValue)
            ->first(['id']);

        if (!$opt) abort(422, 'Invalid answer option for this question.');

        DB::transaction(function () use ($sessionId, $questionId, $answerValue) {
            DB::table('session_answers')->updateOrInsert(
                ['assessment_session_id' => $sessionId, 'question_id' => $questionId],
                ['answer_value' => $answerValue, 'updated_at' => now(), 'created_at' => now()]
            );

            $this->applyBayesUpdate($sessionId, $questionId, $answerValue);

            DB::table('assessment_sessions')->where('id', $sessionId)->update([
                'question_count' => DB::raw('question_count + 1'),
                'updated_at' => now(),
            ]);
        });
    }

    public function undoLastAnswer(int $sessionId): void
    {
        $this->ensureSessionExists($sessionId);

        DB::transaction(function () use ($sessionId) {
            $last = DB::table('session_answers')
                ->where('assessment_session_id', $sessionId)
                ->orderByDesc('id')
                ->first(['id']);

            if (!$last) return;

            DB::table('session_answers')->where('id', $last->id)->delete();

            $this->recomputeFromScratch($sessionId);

            DB::table('assessment_sessions')->where('id', $sessionId)->update([
                'question_count' => DB::raw('CASE WHEN question_count > 0 THEN question_count - 1 ELSE 0 END'),
                'updated_at' => now(),
            ]);
        });
    }

    public function getResult(int $sessionId): array
    {
        $this->ensureSessionExists($sessionId);

        // Special case: feeling=good
        $answers = DB::table('session_answers')
            ->where('assessment_session_id', $sessionId)
            ->orderBy('id')
            ->get(['question_id', 'answer_value']);

        if ($answers->count() === 1) {
            $qCode = DB::table('questions')->where('id', $answers[0]->question_id)->value('code');
            if ($qCode === 'feeling' && $answers[0]->answer_value === 'good') {
                $top = (object)[
                    'name' => 'No immediate concern detected',
                    'triage_level' => 'self_care',
                    'prob' => 1.0,
                    'category' => 'General',
                ];

                return [
                    'top' => $top,
                    'top3' => [],
                    'message' => "Glad you're feeling good. If you develop symptoms or have concerns, you can run an assessment anytime.",
                ];
            }
        }

        $top = DB::table('session_posteriors as sp')
            ->join('conditions as c', 'c.id', '=', 'sp.condition_id')
            ->join('categories as cat', 'cat.id', '=', 'c.category_id')
            ->where('sp.assessment_session_id', $sessionId)
            ->orderByDesc('sp.prob')
            ->select('c.name', 'c.triage_level', 'sp.prob', 'cat.label as category')
            ->first();

        $top3 = $this->topN($sessionId, 3);

        return ['top' => $top, 'top3' => $top3];
    }

    // ---------- internals ----------

    private function questionPayload(int $qid, array $top3, bool $canBack): array
    {
        $q = DB::table('questions')->where('id', $qid)->first(['id', 'text']);
        $opts = DB::table('question_options')
            ->where('question_id', $qid)
            ->orderBy('sort_order')
            ->get(['value', 'label']);

        return [
            'should_stop' => false,
            'next_question' => ['id' => $q->id, 'text' => $q->text],
            'next_options' => $opts,
            'top3' => $top3,
            'can_back' => $canBack,
        ];
    }

    private function pickNextQuestion(int $sessionId, array $posterior, array $askedQIds): ?int
    {
        $candidateQIds = DB::table('questions')
            ->where('is_active', true)
            ->when(!empty($askedQIds), fn($q) => $q->whereNotIn('id', $askedQIds))
            ->pluck('id')
            ->all();

        if (empty($candidateQIds)) return null;

        $Hcurrent = $this->entropy($posterior);

        $bestQ = null;
        $bestGain = -INF;

        foreach ($candidateQIds as $qid) {
            $options = DB::table('question_options')
                ->where('question_id', $qid)
                ->orderBy('sort_order')
                ->get(['id']);

            if ($options->isEmpty()) continue;

            $expectedH = 0.0;

            foreach ($options as $opt) {
                $pOpt = $this->probOfOption($posterior, (int)$opt->id);
                if ($pOpt <= 0) continue;

                $updated = $this->simulateUpdate($posterior, (int)$opt->id);
                $expectedH += $pOpt * $this->entropy($updated);
            }

            $gain = $Hcurrent - $expectedH;

            if ($gain > $bestGain) {
                $bestGain = $gain;
                $bestQ = (int)$qid;
            }
        }

        return $bestQ;
    }

    private function applyBayesUpdate(int $sessionId, int $questionId, string $answerValue): void
    {
        $optId = DB::table('question_options')
            ->where('question_id', $questionId)
            ->where('value', $answerValue)
            ->value('id');

        $rows = DB::table('session_posteriors')
            ->where('assessment_session_id', $sessionId)
            ->get(['id', 'condition_id', 'prob']);

        $sum = 0.0;
        $new = [];

        foreach ($rows as $row) {
            $lik = $this->likelihood((int)$row->condition_id, (int)$optId);
            $val = max(1e-12, (float)$row->prob * $lik);
            $new[] = [$row->id, $val];
            $sum += $val;
        }

        $sum = max(1e-12, $sum);

        foreach ($new as [$rowId, $val]) {
            DB::table('session_posteriors')->where('id', $rowId)->update([
                'prob' => $val / $sum,
                'updated_at' => now(),
            ]);
        }
    }

    private function recomputeFromScratch(int $sessionId): void
    {
        $conditions = DB::table('conditions')->select('id', 'prior')->get();
        $sum = (float)($conditions->sum('prior') ?: 1.0);

        foreach ($conditions as $c) {
            $base = ((float)$c->prior) / $sum;
            DB::table('session_posteriors')
                ->where('assessment_session_id', $sessionId)
                ->where('condition_id', $c->id)
                ->update(['prob' => $base, 'updated_at' => now()]);
        }

        $answers = DB::table('session_answers')
            ->where('assessment_session_id', $sessionId)
            ->orderBy('id')
            ->get(['question_id', 'answer_value']);

        foreach ($answers as $a) {
            $this->applyBayesUpdate($sessionId, (int)$a->question_id, (string)$a->answer_value);
        }
    }

    private function likelihood(int $conditionId, int $optionId): float
    {
        $p = DB::table('condition_option_likelihoods')
            ->where('condition_id', $conditionId)
            ->where('question_option_id', $optionId)
            ->value('prob');

        return $p === null ? 0.10 : max(1e-12, (float)$p);
    }

    private function probOfOption(array $posterior, int $optionId): float
    {
        $sum = 0.0;
        foreach ($posterior as $condId => $pc) {
            $sum += (float)$pc * $this->likelihood((int)$condId, $optionId);
        }
        return $sum;
    }

    private function simulateUpdate(array $posterior, int $optionId): array
    {
        $temp = [];
        $sum = 0.0;

        foreach ($posterior as $condId => $pc) {
            $val = max(1e-12, (float)$pc * $this->likelihood((int)$condId, $optionId));
            $temp[$condId] = $val;
            $sum += $val;
        }

        $sum = max(1e-12, $sum);
        foreach ($temp as $condId => $val) $temp[$condId] = $val / $sum;

        return $temp;
    }

    private function entropy(array $dist): float
    {
        $H = 0.0;
        foreach ($dist as $p) {
            $p = (float)$p;
            if ($p > 0) $H -= $p * log($p);
        }
        return $H;
    }

    private function posteriorMap(int $sessionId): array
    {
        return DB::table('session_posteriors')
            ->where('assessment_session_id', $sessionId)
            ->pluck('prob', 'condition_id')
            ->toArray();
    }

    private function topN(int $sessionId, int $n): array
    {
        return DB::table('session_posteriors as sp')
            ->join('conditions as c', 'c.id', '=', 'sp.condition_id')
            ->join('categories as cat', 'cat.id', '=', 'c.category_id')
            ->where('sp.assessment_session_id', $sessionId)
            ->orderByDesc('sp.prob')
            ->limit($n)
            ->get(['c.name', 'cat.label as category', 'c.triage_level', 'sp.prob'])
            ->toArray();
    }

    private function shouldStop(int $sessionId, array $posterior): bool
    {
        $count = (int)(DB::table('assessment_sessions')->where('id', $sessionId)->value('question_count') ?? 0);
        if ($count >= $this->maxQuestions) return true;

        $top = 0.0;
        foreach ($posterior as $p) $top = max($top, (float)$p);

        return $top >= $this->stopTopProb;
    }

    private function ensureSessionExists(int $sessionId): void
    {
        if (!DB::table('assessment_sessions')->where('id', $sessionId)->exists()) {
            abort(404, 'Session not found');
        }
    }

    private function qid(string $code): ?int
    {
        $id = DB::table('questions')->where('code', $code)->value('id');
        return $id ? (int)$id : null;
    }

    private function hasAsked(int $sessionId, string $code): bool
    {
        $qid = $this->qid($code);
        if (!$qid) return false;

        return DB::table('session_answers')
            ->where('assessment_session_id', $sessionId)
            ->where('question_id', $qid)
            ->exists();
    }

    private function lastAnswer(int $sessionId): ?object
    {
        return DB::table('session_answers')
            ->where('assessment_session_id', $sessionId)
            ->orderByDesc('id')
            ->first(['question_id', 'answer_value']);
    }
}