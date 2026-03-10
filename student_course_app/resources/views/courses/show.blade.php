@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Course Details</h3>

    <div class="card mb-3">
        <div class="card-body">
            <p><b>Code:</b> {{ $course->code }}</p>
            <p><b>Title:</b> {{ $course->title }}</p>
            <p><b>Credit Hour:</b> {{ $course->credit_hour }}</p>

            <a class="btn btn-warning" href="{{ route('courses.edit', $course) }}">Edit</a>
            <a class="btn btn-secondary" href="{{ route('courses.index') }}">Back</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><b>Enrolled Students ({{ $course->students->count() }})</b></div>
                <div class="card-body">
                    @if($course->students->isEmpty())
                        <p class="mb-0 text-muted">No students enrolled.</p>
                    @else
                        <ul class="mb-0">
                            @foreach($course->students as $s)
                                <li>{{ $s->name }} ({{ $s->matric_no }})</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><b>Assigned Lecturers ({{ $course->lecturers->count() }})</b></div>
                <div class="card-body">
                    @if($course->lecturers->isEmpty())
                        <p class="mb-0 text-muted">No lecturers assigned.</p>
                    @else
                        <ul class="mb-0">
                            @foreach($course->lecturers as $l)
                                <li>{{ $l->name }} ({{ $l->staff_id }})</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
