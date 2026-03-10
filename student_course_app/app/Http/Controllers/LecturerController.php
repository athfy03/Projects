<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::orderBy('staff_id')->paginate(10);
        return view('lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        return view('lecturers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'staff_id' => 'required|string|max:50|unique:lecturers,staff_id',
            'email' => 'required|email|max:255|unique:lecturers,email',
        ]);

        Lecturer::create($data);

        return redirect()->route('lecturers.index')->with('success', 'Lecturer created.');
    }

    public function show(Lecturer $lecturer)
    {
        return view('lecturers.show', compact('lecturer'));
    }

    public function edit(Lecturer $lecturer)
    {
        return view('lecturers.edit', compact('lecturer'));
    }

    public function update(Request $request, Lecturer $lecturer)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'staff_id' => 'required|string|max:50|unique:lecturers,staff_id,' . $lecturer->id,
            'email' => 'required|email|max:255|unique:lecturers,email,' . $lecturer->id,
        ]);

        $lecturer->update($data);

        return redirect()->route('lecturers.index')->with('success', 'Lecturer updated.');
    }

    public function destroy(Lecturer $lecturer)
    {
        $lecturer->delete();
        return redirect()->route('lecturers.index')->with('success', 'Lecturer deleted.');
    }
}
