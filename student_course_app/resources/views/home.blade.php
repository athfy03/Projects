@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h3>Home</h3>
            <p class="mb-3">Welcome, {{ auth()->user()->name }}!</p>

            <div class="d-flex gap-2 flex-wrap">
                <a class="btn btn-primary" href="{{ route('students.index') }}">Students</a>
                <a class="btn btn-primary" href="{{ route('courses.index') }}">Courses</a>
                <a class="btn btn-primary" href="{{ route('lecturers.index') }}">Lecturers</a>
                <a class="btn btn-secondary" href="{{ route('report.index') }}">Report</a>
            </div>
        </div>
    </div>
</div>
@endsection
