@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Report</h3>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card"><div class="card-body">
                <h5>Total Students</h5>
                <h2>{{ $totalStudents }}</h2>
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card"><div class="card-body">
                <h5>Total Courses</h5>
                <h2>{{ $totalCourses }}</h2>
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card"><div class="card-body">
                <h5>Total Lecturers</h5>
                <h2>{{ $totalLecturers }}</h2>
            </div></div>
        </div>
    </div>

    <h5 class="mb-2">Students Enrolled Per Course</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr><th>Code</th><th>Title</th><th>Enrolled Students</th></tr>
        </thead>
        <tbody>
            @foreach($courses as $c)
                <tr>
                    <td>{{ $c->code }}</td>
                    <td>{{ $c->title }}</td>
                    <td>{{ $c->students_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
