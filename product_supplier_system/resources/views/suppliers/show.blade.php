@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Supplier Details</h2>

    <div class="card mb-4">
        <div class="card-body">

            <h4>{{ $supplier->name }}</h4>
            <p><strong>Address:</strong> {{ $supplier->address }}</p>
            <p><strong>Contact:</strong> {{ $supplier->contactNo }}</p>

        </div>
    </div>

    <h4 class="mb-3">Products Supplied</h4>

    @if($supplier->products->count())
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Barcode</th>
            </tr>
        </thead>

        <tbody>
            @foreach($supplier->products as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->barcode }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No products for this supplier.</p>
    @endif

    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary mt-3">Back</a>

</div>
@endsection
