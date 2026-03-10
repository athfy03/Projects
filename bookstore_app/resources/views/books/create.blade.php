@extends('layouts.app')

@section('content')
<h4 class="mb-3">Add Book</h4>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('books.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input name="title" class="form-control" value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">ISBN</label>
                <input name="isbn" class="form-control" value="{{ old('isbn') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Price (RM)</label>
                <input name="price" type="number" step="0.01" class="form-control" value="{{ old('price') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Authors (Many-to-Many)</label>
                <select name="authors[]" class="form-select" multiple>
                    @foreach($authors as $a)
                        <option value="{{ $a->id }}" @selected(collect(old('authors'))->contains($a->id))>
                            {{ $a->name }} ({{ $a->email }})
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Hold Ctrl/Command to select multiple.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Categories (Many-to-Many)</label>
                <select name="categories[]" class="form-select" multiple>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" @selected(collect(old('categories'))->contains($c->id))>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Hold Ctrl/Command to select multiple.</div>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">Save</button>
                <a class="btn btn-secondary" href="{{ route('books.index') }}">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
