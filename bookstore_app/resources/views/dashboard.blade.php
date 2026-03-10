@extends('layouts.app')

@section('content')
<div class="p-4 bg-light rounded border">
    <h3 class="mb-1">Bookstore Management System</h3>
    <p class="mb-0">Use the navigation bar to manage Books, Authors, Categories, and view Reports.</p>

    <div class="mt-3 d-flex gap-2 flex-wrap">
        <a href="{{ route('books.index') }}" class="btn btn-primary">Books</a>
        <a href="{{ route('authors.index') }}" class="btn btn-secondary">Authors</a>
        <a href="{{ route('categories.index') }}" class="btn btn-success">Categories</a>
        <a href="{{ route('report.index') }}" class="btn btn-dark">Report</a>
    </div>
</div>
@endsection
