<?php

namespace App\Http\Controllers;

use App\Services\AdaptiveEngine;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function start(AdaptiveEngine $engine)
    {
        $sessionId = $engine->startSession();
        return redirect()->route('session.show', ['session' => $sessionId]);
    }

    public function show(int $session, AdaptiveEngine $engine)
    {
        $state = $engine->getState($session);

        if ($state['should_stop'] || $state['next_question'] === null) {
            return redirect()->route('session.result', ['session' => $session]);
        }

        return view('question', [
            'sessionId' => $session,
            'question'  => $state['next_question'],
            'options'   => $state['next_options'],
            'top3'      => $state['top3'],
            'canBack'   => $state['can_back'],
        ]);
    }

    public function answer(int $session, Request $request, AdaptiveEngine $engine)
    {
        $request->validate([
            'question_id' => ['required', 'integer'],
            'answer_value' => ['required', 'string', 'max:64'],
        ]);

        $engine->submitAnswer($session, (int)$request->question_id, (string)$request->answer_value);

        return redirect()->route('session.show', ['session' => $session]);
    }

    public function back(int $session, AdaptiveEngine $engine)
    {
        $engine->undoLastAnswer($session);
        return redirect()->route('session.show', ['session' => $session]);
    }

    public function result(int $session, AdaptiveEngine $engine)
    {
        $result = $engine->getResult($session);

        return view('result', [
            'sessionId' => $session,
            'top'       => $result['top'],
            'top3'      => $result['top3'],
            'message'   => $result['message'] ?? null,
        ]);
    }

    public function restart(AdaptiveEngine $engine)
    {
        $sessionId = $engine->startSession();
        return redirect()->route('session.show', ['session' => $sessionId]);
    }
}