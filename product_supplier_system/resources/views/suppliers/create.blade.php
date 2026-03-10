@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Add New Supplier</h2>

    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Supplier Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input type="text" name="contactNo" class="form-control" required>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Back</a>
    </form>

</div>
@endsection
