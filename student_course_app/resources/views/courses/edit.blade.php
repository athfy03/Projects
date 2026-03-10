@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Edit Course</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <p class="fw-bold mb-2">Please fix the errors below:</p>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('courses.update', $course) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Course Code</label>
            <input class="form-control" name="code" value="{{ old('code', $course->code) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Course Title</label>
            <input class="form-control" name="title" value="{{ old('title', $course->title) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Credit Hour</label>
            <input type="number" class="form-control" name="credit_hour"
                   value="{{ old('credit_hour', $course->credit_hour) }}" min="1" max="30">
        </div>

        <hr>

        @php
            $selectedStudents = old('student_ids', $course->students->pluck('id')->toArray());
            $selectedLecturers = old('lecturer_ids', $course->lecturers->pluck('id')->toArray());
        @endphp

        <div class="mb-3">
            <label class="form-label">Enroll Students</label>
            <select name="student_ids[]" class="form-select" multiple size="8">
                @foreach($students as $s)
                    <option value="{{ $s->id }}" @selected(in_array($s->id, $selectedStudents))>
                        {{ $s->name }} ({{ $s->matric_no }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Assign Lecturers</label>
            <select name="lecturer_ids[]" class="form-select" multiple size="6">
                @foreach($lecturers as $l)
                    <option value="{{ $l->id }}" @selected(in_array($l->id, $selectedLecturers))>
                        {{ $l->name }} ({{ $l->staff_id }})
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
