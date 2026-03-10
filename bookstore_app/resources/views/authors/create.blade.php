@extends('layouts.app')

@section('content')
<h4 class="mb-3">Add Author</h4>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('authors.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input name="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">Save</button>
                <a class="btn btn-secondary" href="{{ route('authors.index') }}">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
