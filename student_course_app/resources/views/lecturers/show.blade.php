@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Lecturer Details</h3>

    <div class="card">
        <div class="card-body">
            <p><b>Name:</b> {{ $lecturer->name }}</p>
            <p><b>Staff ID:</b> {{ $lecturer->staff_id }}</p>
            <p><b>Email:</b> {{ $lecturer->email }}</p>

            <a class="btn btn-warning" href="{{ route('lecturers.edit', $lecturer) }}">Edit</a>
            <a class="btn btn-secondary" href="{{ route('lecturers.index') }}">Back</a>
        </div>
    </div>
</div>
@endsection
