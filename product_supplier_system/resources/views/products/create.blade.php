@extends('layouts.app')

@section('content')
<h2 class="mb-4">Add New Product</h2>

<form action="{{ route('products.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Product Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Barcode</label>
        <input type="text" name="barcode" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Supplier</label>
        <select name="supplier_id" class="form-control" required>
            <option value="">-- Choose Supplier --</option>
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success">Save</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>

</form>
@endsection
