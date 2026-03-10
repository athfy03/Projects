@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Edit Borrowing</h1>

    <form action="{{ route('borrowings.update', $borrowing) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Member</label>
            <select name="member_id" class="form-control">
                @foreach($members as $member)
                <option value="{{ $member->id }}" 
                    {{ $borrowing->member_id == $member->id ? 'selected' : '' }}>
                    {{ $member->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Book</label>
            <select name="book_id" class="form-control">
                @foreach($books as $book)
                <option value="{{ $book->id }}"
                    {{ $borrowing->book_id == $book->id ? 'selected' : '' }}>
                    {{ $book->title }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Borrowed At</label>
            <input type="date" name="borrowed_at" class="form-control"
                   value="{{ $borrowing->borrowed_at }}">
        </div>

        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control"
                   value="{{ $borrowing->due_date }}">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option {{ $borrowing->status == 'Borrowed' ? 'selected' : '' }}>Borrowed</option>
                <option {{ $borrowing->status == 'Returned' ? 'selected' : '' }}>Returned</option>
            </select>
        </div>

        <button class="btn btn-success">Update</button>
    </form>

</div>
@endsection
