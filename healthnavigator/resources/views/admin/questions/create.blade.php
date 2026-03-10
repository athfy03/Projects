@extends('layout')

@section('content')
<div class="card" style="max-width:900px;text-align:left;">
  <h2 style="margin-top:0;">Add Question</h2>

  @if($errors->any())
    <div style="color:#b00020;"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
  @endif

  <form method="POST" action="{{ route('questions.store') }}">
    @csrf
    <p><label>Code (unique)</label><br><input name="code" value="{{ old('code') }}" required></p>
    <p><label>Text</label><br><input name="text" value="{{ old('text') }}" required style="width:100%;"></p>
    <p><label><input type="checkbox" name="is_active" value="1" checked> Active</label></p>

    <hr>
    <h3>Options (at least 2)</h3>

    @for($i=0; $i<3; $i++)
      <div style="display:flex;gap:10px;margin-bottom:8px;">
        <input name="option_value[]" placeholder="value" value="{{ old('option_value.'.$i) }}" required>
        <input name="option_label[]" placeholder="label" value="{{ old('option_label.'.$i) }}" required>
        <input name="option_order[]" type="number" placeholder="order" value="{{ old('option_order.'.$i, $i) }}" required style="width:90px;">
      </div>
    @endfor

    <button class="btn" type="submit">Save</button>
  </form>

  <p style="color:#666;margin-top:10px;">Tip: For yes/no/unsure, use values: yes, no, unsure.</p>
</div>
@endsection