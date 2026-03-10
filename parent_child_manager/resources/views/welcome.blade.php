@extends('layout')

@section('content')

<h1>School Management System</h1>

<ul>
    <li><a class="btn btn-blue" href="{{ route('guardians.index') }}">Manage Guardians</a></li>
    <br>
    <li><a class="btn btn-blue" href="{{ route('children.index') }}">Manage Children</a></li>
</ul>

@endsection
