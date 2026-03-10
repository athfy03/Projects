@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Add Course</h3>

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

    <form method="POST" action="{{ route('courses.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Course Code</label>
            <input class="form-control" name="code" value="{{ old('code') }}" placeholder="e.g. CSB123">
        </div>

        <div class="mb-3">
            <label class="form-label">Course Title</label>
            <input class="form-control" name="title" value="{{ old('title') }}" placeholder="e.g. Web Programming">
        </div>

        <div class="mb-3">
            <label class="form-label">Credit Hour</label>
            <input type="number" class="form-control" name="credit_hour" value="{{ old('credit_hour') }}" min="1" max="30">
        </div>

        <hr>

        <div class="mb-3">
            <label class="form-label">Enroll Students (optional)</label>
            <select name="student_ids[]" class="form-select" multiple size="8">
                @foreach($students as $s)
                    <option value="{{ $s->id }}" @selected(in_array($s->id, old('student_ids', [])))>
                        {{ $s->name }} ({{ $s->matric_no }})
                    </option>
                @endforeach
            </select>
            <div class="form-text">Hold Ctrl (Windows) to select multiple.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Assign Lecturers (optional)</label>
            <select name="lecturer_ids[]" class="form-select" multiple size="6">
                @foreach($lecturers as $l)
                    <option value="{{ $l->id }}" @selected(in_array($l->id, old('lecturer_ids', [])))>
                        {{ $l->name }} ({{ $l->staff_id }})
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
