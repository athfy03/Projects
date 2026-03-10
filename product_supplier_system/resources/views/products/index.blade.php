@extends('layouts.app')

@section('content')
<h1 class="mb-4">Products List</h1>

<a href="{{ url('/') }}" class="btn btn-secondary mb-3">🏠 Home</a>
<a href="{{ route('products.create') }}" class="btn btn-primary mb-3 ms-2">➕ Add New Product</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Barcode</th>
            <th>Supplier</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($products as $p)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $p->name }}</td>
            <td>{{ $p->barcode }}</td>
            <td>{{ $p->supplier->name }}</td>
            <td>
                <a href="{{ route('products.show', $p->id) }}" class="btn btn-primary btn-sm">View</a>
                <a href="{{ route('products.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('products.destroy', $p->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
