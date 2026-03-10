@extends('layout')

@section('content')
  <div class="card">
    <p class="q"><strong>{{ $question['text'] }}</strong></p>

    <form method="POST" action="{{ route('session.answer', ['session'=>$sessionId]) }}">
      @csrf
      <input type="hidden" name="question_id" value="{{ $question['id'] }}">

      <div class="grid">
        @foreach($options as $opt)
          <button class="btn" type="submit" name="answer_value" value="{{ $opt->value }}">
            {{ $opt->label }}
          </button>
        @endforeach
      </div>
    </form>

    <div class="row">
      <form method="POST" action="{{ route('session.back', ['session'=>$sessionId]) }}">
        @csrf
        <button class="btn" type="submit" style="background:#fff;" {{ $canBack ? '' : 'disabled' }}>
          ← Previous Question
        </button>
      </form>

      <form method="POST" action="{{ route('session.restart') }}">
        @csrf
        <button class="btn" type="submit">Restart</button>
      </form>
    </div>

    <div class="debug">
      <strong>Probability</strong>
      <ol style="margin:8px 0 0 18px;">
        @foreach($top3 as $row)
          <li>
            {{ $row->name }}
            <span class="pill">{{ $row->category }}</span>
            — {{ number_format($row->prob * 100, 1) }}%
          </li>
        @endforeach
      </ol>
    </div>
  </div>
@endsection