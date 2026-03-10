@extends('layouts.app')

@section('content')
<h4 class="mb-3">Edit Book</h4>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('books.update', $book) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input name="title" class="form-control" value="{{ old('title', $book->title) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">ISBN</label>
                <input name="isbn" class="form-control" value="{{ old('isbn', $book->isbn) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Price (RM)</label>
                <input name="price" type="number" step="0.01" class="form-control" value="{{ old('price', $book->price) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Authors</label>
                <select name="authors[]" class="form-select" multiple>
                    @foreach($authors as $a)
                        @php
                            $isSelected = collect(old('authors', $selectedAuthors))->contains($a->id);
                        @endphp
                        <option value="{{ $a->id }}" @selected($isSelected)>
                            {{ $a->name }} ({{ $a->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Categories</label>
                <select name="categories[]" class="form-select" multiple>
                    @foreach($categories as $c)
                        @php
                            $isSelected = collect(old('categories', $selectedCategories))->contains($c->id);
                        @endphp
                        <option value="{{ $c->id }}" @selected($isSelected)>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">Update</button>
                <a class="btn btn-secondary" href="{{ route('books.index') }}">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
