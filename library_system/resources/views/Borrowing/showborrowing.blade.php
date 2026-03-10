@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Borrowing Details</h1>

    <ul class="list-group">
        <li class="list-group-item"><strong>Member:</strong> {{ $borrowing->member->name }}</li>
        <li class="list-group-item"><strong>Book:</strong> {{ $borrowing->book->title }}</li>
        <li class="list-group-item"><strong>Borrowed At:</strong> {{ $borrowing->borrowed_at }}</li>
        <li class="list-group-item"><strong>Due Date:</strong> {{ $borrowing->due_date }}</li>
        <li class="list-group-item"><strong>Status:</strong> {{ $borrowing->status }}</li>
    </ul>

    <a href="{{ route('borrowings.index') }}" class="btn btn-secondary mt-3">Back</a>

</div>
@endsection
