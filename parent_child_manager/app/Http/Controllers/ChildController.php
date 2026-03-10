<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Guardian;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $children = Child::with('guardian')
                    ->where('name', 'LIKE', "%$search%")
                    ->paginate(5);

        return view('children.index', compact('children', 'search'));
    }


    public function create()
    {
        $guardians = Guardian::all();
        return view('children.create', compact('guardians'));
    }

    public function store(Request $request)
    {
        Child::create($request->all());
        return redirect()->route('children.index')->with('success','Child created.');
    }

    public function show(Child $child)
    {
        return view('children.show', compact('child'));
    }

    public function edit(Child $child)
    {
        $guardians = Guardian::all();
        return view('children.edit', compact('child','guardians'));
    }

    public function update(Request $request, Child $child)
    {
        $child->update($request->all());
        return redirect()->route('children.index')->with('success','Updated.');
    }

    public function destroy(Child $child)
    {
        $child->delete();
        return redirect()->route('children.index')->with('success','Deleted.');
    }
}
