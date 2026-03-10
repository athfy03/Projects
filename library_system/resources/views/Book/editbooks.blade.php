@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Book</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('books.update', $book) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $book->title}}">
        </div>
        <div class="mb-3">
            <label>Author</label>
            <input type="text" name="author" class="form-control" value="{{ $book->author }}">
        </div>
        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control">
                <option value="normal" {{ $book->type == 'normal' ? 'selected' : ''}}>Normal</option>
                <option value="special" {{ $book->type == 'special' ? 'selected' : ''}}>Special</option>
            </select>
        </div>
        <div class="mb-3">
            <label>ISBN</label>
            <input type="text" name="isbn" class="form-control" value="{{ $book->isbn}}">
        </div>
        
        <button class="btn btn-success">Update</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
