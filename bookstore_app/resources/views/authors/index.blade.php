@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Authors</h4>
    <a class="btn btn-primary" href="{{ route('authors.create') }}">Add Author</a>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-striped align-middle">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Books Written</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($authors as $author)
                <tr>
                    <td>{{ $author->id }}</td>
                    <td>{{ $author->name }}</td>
                    <td>{{ $author->email }}</td>
                    <td>{{ $author->books_count }}</td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-warning" href="{{ route('authors.edit', $author) }}">Edit</a>
                        <form action="{{ route('authors.destroy', $author) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this author?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No authors found.</td></tr>
            @endforelse
            </tbody>
        </table>

        {{ $authors->links() }}
    </div>
</div>
@endsection
