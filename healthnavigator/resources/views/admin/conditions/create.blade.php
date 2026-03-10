@extends('layout')

@section('content')
<div class="card" style="max-width:800px;text-align:left;">
  <h2 style="margin-top:0;">Add Condition</h2>

  @if($errors->any())
    <div style="color:#b00020;"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
  @endif

  <form method="POST" action="{{ route('conditions.store') }}">
    @csrf
    <p>
      <label>Category</label><br>
      <select name="category_id" required>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}">{{ $cat->label }}</option>
        @endforeach
      </select>
    </p>

    <p><label>Name</label><br><input name="name" value="{{ old('name') }}" required></p>
    <p><label>Slug (optional)</label><br><input name="slug" value="{{ old('slug') }}"></p>

    <p>
      <label>Triage level</label><br>
      <select name="triage_level" required>
        <option value="self_care">self_care</option>
        <option value="clinic" selected>clinic</option>
        <option value="urgent">urgent</option>
      </select>
    </p>

    <p><label>Prior</label><br><input name="prior" type="number" step="0.01" value="{{ old('prior', 1.0) }}" required></p>
    <p><label>Description (optional)</label><br><textarea name="description">{{ old('description') }}</textarea></p>

    <button class="btn" type="submit">Save</button>
  </form>
</div>
@endsection