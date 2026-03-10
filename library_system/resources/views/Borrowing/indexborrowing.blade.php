@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Borrowings</h1>

    <a href="{{ route('borrowings.create') }}" class="btn btn-primary mb-3">Add Borrowing</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Member</th>
                <th>Book</th>
                <th>Borrowed At</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($borrowings as $borrowing)
            <tr>
                <td>{{ $borrowing->member->name }}</td>
                <td>{{ $borrowing->book->title }}</td>
                <td>{{ $borrowing->borrowed_at }}</td>
                <td>{{ $borrowing->due_date }}</td>
                <td>{{ $borrowing->status }}</td>
                <td>
                    <a href="{{ route('borrowings.show', $borrowing) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('borrowings.edit', $borrowing) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('borrowings.destroy', $borrowing) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Delete this borrowing?')" class="btn btn-danger btn-sm">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
@endsection
