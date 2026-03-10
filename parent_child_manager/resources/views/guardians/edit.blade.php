@extends('layout')

@section('content')

<h1>Edit Guardian</h1>

<form method="POST" action="{{ route('guardians.update', $guardian->id) }}">
    @csrf
    @method('PUT')

    Father Name:
    <input type="text" name="father_name" value="{{ $guardian->father_name }}">

    Mother Name:
    <input type="text" name="mother_name" value="{{ $guardian->mother_name }}">

    Contact No:
    <input type="text" name="contact_number" value="{{ $guardian->contact_number }}">

    <button class="btn btn-green">Update</button>
    <a class="btn btn-grey" href="{{ route('guardians.index') }}">Back</a>

</form>

@endsection
