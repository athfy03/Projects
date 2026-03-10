@extends('layouts.app')

@section('content')
<h2 class="mb-4">Edit Product</h2>

<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Product Name</label>
        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Barcode</label>
        <input type="text" name="barcode" class="form-control" value="{{ $product->barcode }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Supplier</label>
        <select name="supplier_id" class="form-control" required>
            @foreach($suppliers as $s)
                <option value="{{ $s->id }}" {{ $product->supplier_id == $s->id ? 'selected' : '' }}>
                    {{ $s->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-warning">Update</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>

</form>
@endsection
