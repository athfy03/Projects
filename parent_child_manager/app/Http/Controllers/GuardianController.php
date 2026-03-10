<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $guardians = Guardian::where('father_name', 'LIKE', "%$search%")
                    ->orWhere('mother_name', 'LIKE', "%$search%")
                    ->paginate(5);

        return view('guardians.index', compact('guardians', 'search'));
    }


    public function create()
    {
        return view('guardians.create');
    }

    public function store(Request $request)
    {
        Guardian::create($request->all());
        return redirect()->route('guardians.index')->with('success', 'Guardian created.');
    }

    public function show(Guardian $guardian)
    {
        $children = $guardian->children;
        return view('guardians.show', compact('guardian', 'children'));
    }

    public function edit(Guardian $guardian)
    {
        return view('guardians.edit', compact('guardian'));
    }

    public function update(Request $request, Guardian $guardian)
    {
        $guardian->update($request->all());
        return redirect()->route('guardians.index')->with('success', 'Updated.');
    }

    public function destroy(Guardian $guardian)
    {
        $guardian->delete();
        return redirect()->route('guardians.index')->with('success', 'Deleted.');
    }
}
