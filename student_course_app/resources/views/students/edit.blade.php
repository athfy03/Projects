@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Edit Student</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('students.update', $student) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input class="form-control" name="name" value="{{ old('name', $student->name) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Matric No</label>
            <input class="form-control" name="matric_no" value="{{ old('matric_no', $student->matric_no) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" name="email" value="{{ old('email', $student->email) }}">
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
