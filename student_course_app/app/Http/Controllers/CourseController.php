<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('students')->orderBy('code')->paginate(10);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $students = Student::orderBy('name')->get();
        $lecturers = Lecturer::orderBy('name')->get();

        return view('courses.create', compact('students', 'lecturers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:courses,code',
            'title' => 'required|string|max:255',
            'credit_hour' => 'required|integer|min:1|max:30',

            // pivot inputs (optional)
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:students,id',
            'lecturer_ids' => 'nullable|array',
            'lecturer_ids.*' => 'exists:lecturers,id',
        ]);

        $course = Course::create([
            'code' => $data['code'],
            'title' => $data['title'],
            'credit_hour' => $data['credit_hour'],
        ]);

        // Save pivot relationships
        $course->students()->sync($data['student_ids'] ?? []);
        $course->lecturers()->sync($data['lecturer_ids'] ?? []);

        return redirect()->route('courses.index')->with('success', 'Course created.');
    }

    public function show(Course $course)
    {
        $course->load(['students', 'lecturers']);
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $students = Student::orderBy('name')->get();
        $lecturers = Lecturer::orderBy('name')->get();

        $course->load(['students', 'lecturers']);

        return view('courses.edit', compact('course', 'students', 'lecturers'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'title' => 'required|string|max:255',
            'credit_hour' => 'required|integer|min:1|max:30',

            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:students,id',
            'lecturer_ids' => 'nullable|array',
            'lecturer_ids.*' => 'exists:lecturers,id',
        ]);

        $course->update([
            'code' => $data['code'],
            'title' => $data['title'],
            'credit_hour' => $data['credit_hour'],
        ]);

        // Update pivot relationships
        $course->students()->sync($data['student_ids'] ?? []);
        $course->lecturers()->sync($data['lecturer_ids'] ?? []);

        return redirect()->route('courses.index')->with('success', 'Course updated.');
    }

    public function destroy(Course $course)
    {
        // detach optional (not required, but clean)
        $course->students()->detach();
        $course->lecturers()->detach();

        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted.');
    }
}
