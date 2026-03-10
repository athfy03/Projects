@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Book Details</h1>

    <table class="table table-striped table-bordered w-auto">
        <tbody>
            <tr>
                <th style="width: 220px;">Title</th>
                <td>{{ $book->title }}</td>
            </tr>
            <tr>
                <th>Author</th>
                <td>{{ $book->author }}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{{ ucfirst($book->type) }}</td>
            </tr>
            <tr>
                <th>ISBN</th>
                <td>{{ $book->isbn }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($book->status) }}</td>
            </tr>
            <tr>
                <th>Created</th>
                <td>{{ optional($book->created_at)->format('d M Y, h:i A') }}</td>
            </tr>
            <tr>
                <th>Last Updated</th>
                <td>{{ optional($book->updated_at)->format('d M Y, h:i A') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="d-flex gap-2">
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Delete this book?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>
@endsection