@extends('layouts.app')

@section('content')
<h2 class="mb-4">Product Details</h2>

<div class="card mb-4">
    <div class="card-body">

        <h4>{{ $product->name }}</h4>

        <p><strong>Barcode:</strong> {{ $product->barcode }}</p>

        <p>
            <strong>Supplier:</strong>  
            {{ $product->supplier->name }}
        </p>

    </div>
</div>

<a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
@endsection
