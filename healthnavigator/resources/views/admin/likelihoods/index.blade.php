@extends('layout')

@section('content')
<div class="card" style="max-width:980px;text-align:left;">
  <h2 style="margin-top:0;">Likelihood Editor</h2>

  @if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
  @endif

  @if($errors->any())
    <div style="color:#b00020;">
      <ul>
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="GET" action="{{ route('admin.likelihoods.index') }}">
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
      <div>
        <label>Category</label><br>
        <select name="category_id" onchange="this.form.submit()">
          <option value="">-- choose --</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ (int)$categoryId===$cat->id ? 'selected':'' }}>{{ $cat->label }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label>Condition</label><br>
        <select name="condition_id" onchange="this.form.submit()">
          <option value="">-- choose --</option>
          @foreach($conditions as $c)
            <option value="{{ $c->id }}" {{ (int)$conditionId===$c->id ? 'selected':'' }}>{{ $c->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label>Question</label><br>
        <select name="question_id" onchange="this.form.submit()">
          <option value="">-- choose --</option>
          @foreach($questions as $q)
            <option value="{{ $q->id }}" {{ (int)$questionId===$q->id ? 'selected':'' }}>{{ $q->text }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </form>

  @if($conditionId && $questionId && $options->count())
    <hr>

    <form method="POST" action="{{ route('admin.likelihoods.save') }}">
      @csrf
      <input type="hidden" name="condition_id" value="{{ $conditionId }}">
      <input type="hidden" name="question_id" value="{{ $questionId }}">

      <p>Set probabilities (must sum to <strong>1.0</strong>):</p>

      <table border="1" cellpadding="8" cellspacing="0" style="width:100%;border-collapse:collapse;">
        <tr>
          <th>Option</th>
          <th>Probability</th>
        </tr>
        @foreach($options as $opt)
          <tr>
            <td>{{ $opt->label }} <small style="color:#666;">({{ $opt->value }})</small></td>
            <td>
              <input type="number" step="0.01" min="0" max="1"
                     name="probs[{{ $opt->id }}]"
                     value="{{ old('probs.'.$opt->id, $existing[$opt->id] ?? 0) }}">
            </td>
          </tr>
        @endforeach
      </table>

      <button class="btn" type="submit" style="margin-top:12px;">Save</button>
    </form>
  @endif
</div>
@endsection