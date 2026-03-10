<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')->orderBy('label')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:50','unique:categories,name'],
            'label' => ['required','string','max:100'],
        ]);

        DB::table('categories')->insert([
            'name' => $data['name'],
            'label' => $data['label'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created.');
    }

    public function edit(int $category)
    {
        $categoryRow = DB::table('categories')->where('id', $category)->first();
        abort_if(!$categoryRow, 404);
        return view('admin.categories.edit', ['category' => $categoryRow]);
    }

    public function update(Request $request, int $category)
    {
        $categoryRow = DB::table('categories')->where('id', $category)->first();
        abort_if(!$categoryRow, 404);

        $data = $request->validate([
            'name'  => ['required','string','max:50','unique:categories,name,' . $category],
            'label' => ['required','string','max:100'],
        ]);

        DB::table('categories')->where('id', $category)->update([
            'name' => $data['name'],
            'label' => $data['label'],
            'updated_at' => now(),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(int $category)
    {
        DB::table('categories')->where('id', $category)->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }
}