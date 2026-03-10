<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = DB::table('questions')->orderBy('text')->get();
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.questions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required','string','max:60','unique:questions,code'],
            'text' => ['required','string','max:255'],
            'is_active' => ['nullable','boolean'],

            'option_value' => ['required','array','min:2'],
            'option_value.*' => ['required','string','max:64'],
            'option_label' => ['required','array','min:2'],
            'option_label.*' => ['required','string','max:80'],
            'option_order' => ['required','array','min:2'],
            'option_order.*' => ['required','integer','min:0','max:999'],
        ]);

        DB::transaction(function () use ($data) {
            $qid = DB::table('questions')->insertGetId([
                'code' => $data['code'],
                'text' => $data['text'],
                'is_active' => (bool)($data['is_active'] ?? true),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $count = count($data['option_value']);
            for ($i = 0; $i < $count; $i++) {
                DB::table('question_options')->insert([
                    'question_id' => $qid,
                    'value' => $data['option_value'][$i],
                    'label' => $data['option_label'][$i],
                    'sort_order' => (int)$data['option_order'][$i],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return redirect()->route('questions.index')->with('success', 'Question created.');
    }

    public function edit(int $question)
    {
        $questionRow = DB::table('questions')->where('id', $question)->first();
        abort_if(!$questionRow, 404);

        $options = DB::table('question_options')->where('question_id', $question)->orderBy('sort_order')->get();

        return view('admin.questions.edit', [
            'question' => $questionRow,
            'options' => $options,
        ]);
    }

    public function update(Request $request, int $question)
    {
        $questionRow = DB::table('questions')->where('id', $question)->first();
        abort_if(!$questionRow, 404);

        $data = $request->validate([
            'code' => ['required','string','max:60','unique:questions,code,' . $question],
            'text' => ['required','string','max:255'],
            'is_active' => ['nullable','boolean'],

            'option_value' => ['required','array','min:2'],
            'option_value.*' => ['required','string','max:64'],
            'option_label' => ['required','array','min:2'],
            'option_label.*' => ['required','string','max:80'],
            'option_order' => ['required','array','min:2'],
            'option_order.*' => ['required','integer','min:0','max:999'],
        ]);

        DB::transaction(function () use ($data, $question) {
            DB::table('questions')->where('id', $question)->update([
                'code' => $data['code'],
                'text' => $data['text'],
                'is_active' => (bool)($data['is_active'] ?? true),
                'updated_at' => now(),
            ]);

            // Simple strategy: delete + recreate options (clean and reliable)
            DB::table('question_options')->where('question_id', $question)->delete();

            $count = count($data['option_value']);
            for ($i = 0; $i < $count; $i++) {
                DB::table('question_options')->insert([
                    'question_id' => $question,
                    'value' => $data['option_value'][$i],
                    'label' => $data['option_label'][$i],
                    'sort_order' => (int)$data['option_order'][$i],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return redirect()->route('questions.index')->with('success', 'Question updated.');
    }

    public function destroy(int $question)
    {
        DB::table('questions')->where('id', $question)->delete();
        return redirect()->route('questions.index')->with('success', 'Question deleted.');
    }
}