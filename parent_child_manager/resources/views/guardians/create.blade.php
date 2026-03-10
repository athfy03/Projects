@extends('layout')

@section('content')

<h1>Add New Guardian</h1>

<form method="POST" action="{{ route('guardians.store') }}">
    @csrf

    Father Name:
    <input type="text" name="father_name">

    Mother Name:
    <input type="text" name="mother_name">

    Contact No:
    <input type="text" name="contact_number">

    <button class="btn btn-green">✔ Save</button>
    <a class="btn btn-grey" href="{{ route('guardians.index') }}">← Back</a>
</form>

@endsection
