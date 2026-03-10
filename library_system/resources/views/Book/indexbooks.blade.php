@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Books</h1>

    <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Add New Book</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Type</th>
                <th>ISBN</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ ucfirst($book->type) }}</td>
                    <td>{{ $book->isbn }}</td>
                    <td>{{ ucfirst($book->status) }}</td>
                    <td>
                        <a href="{{ route('books.show', $book) }}" class="btn btn-info btn-sm">Details</a>

                        <a href="{{ route('books.edit', $book) }}" class="btn btn-warning btn-sm">Edit</a>


                        <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this book?')" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection