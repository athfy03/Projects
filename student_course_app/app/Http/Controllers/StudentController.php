<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'matric_no' => 'required|string|max:50|unique:students,matric_no',
            'email' => 'required|email|max:255|unique:students,email',
        ]);

        Student::create($data);
        return redirect()->route('students.index')->with('success', 'Student created.');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'matric_no' => 'required|string|max:50|unique:students,matric_no,' . $student->id,
            'email' => 'required|email|max:255|unique:students,email,' . $student->id,
        ]);

        $student->update($data);
        return redirect()->route('students.index')->with('success', 'Student updated.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted.');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }
}
