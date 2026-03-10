@extends('layout')

@section('content')

<h1>Add New Child</h1>

<form method="POST" action="{{ route('children.store') }}">
    @csrf

    Name:
    <input type="text" name="name">

    Age:
    <input type="number" name="age">

    Guardian:
    <select name="guardian_id">
        @foreach ($guardians as $g)
            <option value="{{ $g->id }}">
                {{ $g->father_name }} & {{ $g->mother_name }}
            </option>
        @endforeach
    </select>

    <button class="btn btn-green">Save</button>
    <a class="btn btn-grey" href="{{ route('children.index') }}">Back</a>

</form>

@endsection
