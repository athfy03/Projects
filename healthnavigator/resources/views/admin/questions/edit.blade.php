@extends('layout')

@section('content')
<div class="card" style="max-width:900px;text-align:left;">
  <h2 style="margin-top:0;">Edit Question</h2>

  @if($errors->any())
    <div style="color:#b00020;"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
  @endif

  <form method="POST" action="{{ route('questions.update', $question->id) }}">
    @csrf @method('PUT')
    <p><label>Code</label><br><input name="code" value="{{ old('code', $question->code) }}" required></p>
    <p><label>Text</label><br><input name="text" value="{{ old('text', $question->text) }}" required style="width:100%;"></p>
    <p><label><input type="checkbox" name="is_active" value="1" {{ $question->is_active ? 'checked' : '' }}> Active</label></p>

    <hr>
    <h3>Options</h3>

    @foreach($options as $i => $opt)
      <div style="display:flex;gap:10px;margin-bottom:8px;">
        <input name="option_value[]" value="{{ old('option_value.'.$i, $opt->value) }}" required>
        <input name="option_label[]" value="{{ old('option_label.'.$i, $opt->label) }}" required>
        <input name="option_order[]" type="number" value="{{ old('option_order.'.$i, $opt->sort_order) }}" required style="width:90px;">
      </div>
    @endforeach

    <button class="btn" type="submit">Update</button>
  </form>
</div>
@endsection