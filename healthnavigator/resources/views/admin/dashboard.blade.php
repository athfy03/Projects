@extends('layout')

@section('content')
<div class="card" style="max-width:900px;text-align:left;">
  <h2 style="margin-top:0;">Admin Dashboard</h2>
  
  <p>Manage the HealthNavigator knowledge base:</p>
  <ul>
    <a href="{{ route('categories.index') }}">Manage Categories<br></a>
    <a href="{{ route('conditions.index') }}">Manage Conditions<br></a>
    <a href="{{ route('questions.index') }}">Manage Questions<br></a>
    <a href="{{ route('admin.likelihoods.index') }}">Manage Likelihood<br></a>
  </ul>
</div>
@endsection