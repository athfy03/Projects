@extends('layout')

@section('content')

<h1>Guardian Details</h1>

<p><strong>Father:</strong> {{ $guardian->father_name }}</p>
<p><strong>Mother:</strong> {{ $guardian->mother_name }}</p>
<p><strong>Contact No:</strong> {{ $guardian->contact_number }}</p>

<h2>Children</h2>

@if ($children->count() == 0)
    <p>No children available.</p>
@else
    <ul>
        @foreach ($children as $child)
            <li>{{ $child->name }} (Age: {{ $child->age }})</li>
        @endforeach
    </ul>
@endif

<br>
<a class="btn btn-grey" href="{{ route('guardians.index') }}">Back</a>

@endsection
