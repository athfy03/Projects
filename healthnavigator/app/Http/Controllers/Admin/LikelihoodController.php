<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LikelihoodController extends Controller
{
    public function index(Request $request)
    {
        $categories  = DB::table('categories')->orderBy('label')->get();

        $categoryId  = $request->integer('category_id');
        $conditionId = $request->integer('condition_id');
        $questionId  = $request->integer('question_id');

        $conditions = collect();
        if ($categoryId) {
            $conditions = DB::table('conditions')
                ->where('category_id', $categoryId)
                ->orderBy('name')
                ->get();
        }

        $questions = DB::table('questions')
            ->where('is_active', true)
            ->orderBy('text')
            ->get();

        $options = collect();
        if ($questionId) {
            $options = DB::table('question_options')
                ->where('question_id', $questionId)
                ->orderBy('sort_order')
                ->get();
        }

        $existing = collect();
        if ($conditionId && $questionId) {
            $existing = DB::table('condition_option_likelihoods as col')
                ->join('question_options as qo', 'qo.id', '=', 'col.question_option_id')
                ->where('col.condition_id', $conditionId)
                ->where('qo.question_id', $questionId)
                ->pluck('col.prob', 'qo.id'); // [option_id => prob]
        }

        return view('admin.likelihoods.index', compact(
            'categories','categoryId','conditions','conditionId','questions','questionId','options','existing'
        ));
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'condition_id' => ['required','integer','exists:conditions,id'],
            'question_id'  => ['required','integer','exists:questions,id'],
            'probs'        => ['required','array'],
            'probs.*'      => ['nullable','numeric','min:0','max:1'],
        ]);

        $conditionId = (int)$data['condition_id'];
        $questionId  = (int)$data['question_id'];

        $optionIds = DB::table('question_options')
            ->where('question_id', $questionId)
            ->pluck('id')
            ->all();

        $sum = 0.0;
        foreach ($optionIds as $oid) {
            $sum += (float)($data['probs'][$oid] ?? 0);
        }

        if ($sum < 0.99 || $sum > 1.01) {
            return back()->withErrors([
                'probs' => "Probabilities must sum to 1.0 (currently {$sum})."
            ])->withInput();
        }

        DB::transaction(function () use ($conditionId, $optionIds, $data) {
            foreach ($optionIds as $oid) {
                $p = (float)($data['probs'][$oid] ?? 0);
                DB::table('condition_option_likelihoods')->updateOrInsert(
                    ['condition_id' => $conditionId, 'question_option_id' => $oid],
                    ['prob' => $p, 'updated_at' => now()]
                );
            }
        });

        return back()->with('success', 'Likelihoods saved.');
    }
}