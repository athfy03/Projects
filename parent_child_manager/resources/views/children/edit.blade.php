@extends('layout')

@section('content')

<h1>Edit Child</h1>

<form method="POST" action="{{ route('children.update', $child->id) }}">
    @csrf
    @method('PUT')

    Name:
    <input type="text" value="{{ $child->name }}" name="name">

    Age:
    <input type="number" value="{{ $child->age }}" name="age">

    Guardian:
    <select name="guardian_id">
        @foreach ($guardians as $g)
            <option value="{{ $g->id }}" {{ $child->guardian_id == $g->id ? 'selected' : '' }}>
                {{ $g->father_name }} & {{ $g->mother_name }}
            </option>
        @endforeach
    </select>

    <button class="btn btn-green">Update</button>
    <a class="btn btn-grey" href="{{ route('children.index') }}">Back</a>

</form>

@endsection
