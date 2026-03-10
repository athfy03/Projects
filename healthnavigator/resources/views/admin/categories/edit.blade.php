@extends('layout')

@section('content')
<div class="card" style="max-width:700px;text-align:left;">
  <h2 style="margin-top:0;">Edit Category</h2>

  @if($errors->any())
    <div style="color:#b00020;"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
  @endif

  <form method="POST" action="{{ route('categories.update', $category->id) }}">
    @csrf @method('PUT')
    <p>
      <label>Name (unique code)</label><br>
      <input name="name" value="{{ old('name', $category->name) }}" required>
    </p>
    <p>
      <label>Label</label><br>
      <input name="label" value="{{ old('label', $category->label) }}" required>
    </p>
    <button class="btn" type="submit">Update</button>
  </form>
</div>
@endsection