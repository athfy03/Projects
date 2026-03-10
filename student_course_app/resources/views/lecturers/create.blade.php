@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Add Lecturer</h3>

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

    <form method="POST" action="{{ route('lecturers.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input class="form-control" name="name" value="{{ old('name') }}" placeholder="e.g. Dr Ali">
        </div>

        <div class="mb-3">
            <label class="form-label">Staff ID</label>
            <input class="form-control" name="staff_id" value="{{ old('staff_id') }}" placeholder="e.g. ST12345">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" name="email" value="{{ old('email') }}" placeholder="e.g. ali@university.edu">
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('lecturers.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
