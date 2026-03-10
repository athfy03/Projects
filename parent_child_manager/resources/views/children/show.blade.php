@extends('layout')

@section('content')

<h1>Child Details</h1>

<p><strong>Name:</strong> {{ $child->name }}</p>
<p><strong>Age:</strong> {{ $child->age }}</p>

<h2>Guardian</h2>

<p>{{ $child->guardian->father_name }} & {{ $child->guardian->mother_name }}</p>

<br>
<a class="btn btn-grey" href="{{ route('children.index') }}">Back</a>

@endsection
