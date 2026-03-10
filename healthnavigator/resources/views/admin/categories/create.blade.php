@extends('layout')

@section('content')
<div class="card" style="max-width:700px;text-align:left;">
  <h2 style="margin-top:0;">Add Category</h2>

  @if($errors->any())
    <div style="color:#b00020;"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
  @endif

  <form method="POST" action="{{ route('categories.store') }}">
    @csrf
    <p>
      <label>Name (unique code)</label><br>
      <input name="name" value="{{ old('name') }}" placeholder="e.g. allergies" required>
    </p>
    <p>
      <label>Label</label><br>
      <input name="label" value="{{ old('label') }}" placeholder="e.g. Allergies" required>
    </p>
    <button class="btn" type="submit">Save</button>
  </form>
</div>
@endsection