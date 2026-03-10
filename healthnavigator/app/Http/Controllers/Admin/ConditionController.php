<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ConditionController extends Controller
{
    public function index()
    {
        $conditions = DB::table('conditions as c')
            ->join('categories as cat', 'cat.id', '=', 'c.category_id')
            ->orderBy('cat.label')
            ->orderBy('c.name')
            ->select('c.*', 'cat.label as category_label')
            ->get();

        return view('admin.conditions.index', compact('conditions'));
    }

    public function create()
    {
        $categories = DB::table('categories')->orderBy('label')->get();
        return view('admin.conditions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'  => ['required','integer','exists:categories,id'],
            'name'         => ['required','string','max:120'],
            'slug'         => ['nullable','string','max:140','unique:conditions,slug'],
            'triage_level' => ['required','in:self_care,clinic,urgent'],
            'prior'        => ['required','numeric','min:0.01','max:100'],
            'description'  => ['nullable','string'],
        ]);

        $slug = $data['slug'] ?: Str::slug($data['name']);

        DB::table('conditions')->insert([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $slug,
            'triage_level' => $data['triage_level'],
            'prior' => (float)$data['prior'],
            'description' => $data['description'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('conditions.index')->with('success', 'Condition created.');
    }

    public function edit(int $condition)
    {
        $conditionRow = DB::table('conditions')->where('id', $condition)->first();
        abort_if(!$conditionRow, 404);

        $categories = DB::table('categories')->orderBy('label')->get();
        return view('admin.conditions.edit', ['condition' => $conditionRow, 'categories' => $categories]);
    }

    public function update(Request $request, int $condition)
    {
        $conditionRow = DB::table('conditions')->where('id', $condition)->first();
        abort_if(!$conditionRow, 404);

        $data = $request->validate([
            'category_id'  => ['required','integer','exists:categories,id'],
            'name'         => ['required','string','max:120'],
            'slug'         => ['required','string','max:140','unique:conditions,slug,' . $condition],
            'triage_level' => ['required','in:self_care,clinic,urgent'],
            'prior'        => ['required','numeric','min:0.01','max:100'],
            'description'  => ['nullable','string'],
        ]);

        DB::table('conditions')->where('id', $condition)->update([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'triage_level' => $data['triage_level'],
            'prior' => (float)$data['prior'],
            'description' => $data['description'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->route('conditions.index')->with('success', 'Condition updated.');
    }

    public function destroy(int $condition)
    {
        DB::table('conditions')->where('id', $condition)->delete();
        return redirect()->route('conditions.index')->with('success', 'Condition deleted.');
    }
}