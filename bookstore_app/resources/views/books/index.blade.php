@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Books</h4>
    <a class="btn btn-primary" href="{{ route('books.create') }}">Add Book</a>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-striped align-middle">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>ISBN</th>
                <th>Price</th>
                <th>Authors</th>
                <th>Categories</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->isbn }}</td>
                    <td>RM {{ number_format($book->price, 2) }}</td>
                    <td>
                        {{ $book->authors->pluck('name')->implode(', ') ?: '-' }}
                    </td>
                    <td>
                        {{ $book->categories->pluck('name')->implode(', ') ?: '-' }}
                    </td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-warning" href="{{ route('books.edit', $book) }}">Edit</a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this book?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">No books found.</td></tr>
            @endforelse
            </tbody>
        </table>

        {{ $books->links() }}
    </div>
</div>
@endsection
