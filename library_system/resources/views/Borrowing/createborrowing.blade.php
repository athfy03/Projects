@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Add Borrowing</h1>

    <form action="{{ route('borrowings.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Member</label>
            <select name="member_id" class="form-control" required>
                <option value="">Select Member</option>
                @foreach($members as $member)
                <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Book</label>
            <select name="book_id" class="form-control" required>
                <option value="">Select Book</option>
                @foreach($books as $book)
                <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Borrowed At</label>
            <input type="date" name="borrowed_at" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control" required>
        </div>

        <button class="btn btn-success">Save</button>
    </form>

</div>
@endsection
