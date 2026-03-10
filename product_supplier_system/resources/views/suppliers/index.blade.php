@extends('layouts.app')

@section('content')
<h1 class="mb-4">Suppliers List</h1>

<a href="{{ url('/') }}" class="btn btn-secondary mb-3">🏠 Home</a>
<a href="{{ route('suppliers.create') }}" class="btn btn-success mb-3 ms-2">➕ Add New Supplier</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Address</th>
            <th>Contact No</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($suppliers as $s)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $s->name }}</td>
            <td>{{ $s->address }}</td>
            <td>{{ $s->contactNo }}</td>
            <td>
                <a href="{{ route('suppliers.show', $s->id) }}" class="btn btn-primary btn-sm">View</a>
                <a href="{{ route('suppliers.edit', $s->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('suppliers.destroy', $s->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
