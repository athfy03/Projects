@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Edit Supplier</h2>

    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Supplier Name</label>
            <input type="text" name="name" class="form-control" value="{{ $supplier->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="{{ $supplier->address }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input type="text" name="contactNo" class="form-control" value="{{ $supplier->contactNo }}" required>
        </div>

        <button class="btn btn-warning">Update</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Back</a>
    </form>

</div>
@endsection
