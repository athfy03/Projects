@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Edit Lecturer</h3>

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

    <form method="POST" action="{{ route('lecturers.update', $lecturer) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input class="form-control" name="name" value="{{ old('name', $lecturer->name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Staff ID</label>
            <input class="form-control" name="staff_id" value="{{ old('staff_id', $lecturer->staff_id) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" name="email" value="{{ old('email', $lecturer->email) }}">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('lecturers.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
