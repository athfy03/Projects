@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Student Details</h3>

    <div class="card">
        <div class="card-body">
            <p><b>Name:</b> {{ $student->name }}</p>
            <p><b>Matric No:</b> {{ $student->matric_no }}</p>
            <p><b>Email:</b> {{ $student->email }}</p>

            <a class="btn btn-warning" href="{{ route('students.edit',$student) }}">Edit</a>
            <a class="btn btn-secondary" href="{{ route('students.index') }}">Back</a>
        </div>
    </div>
</div>
@endsection
