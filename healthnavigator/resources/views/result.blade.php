@extends('layout')

@section('content')
  <div class="card" style="max-width:680px;">
    <h2 style="margin:0 0 10px;">Your Health Assessment Results</h2>

    @if(!empty($message))
      <p style="margin:0 0 12px; color:#333;">{{ $message }}</p>
    @endif

    @if($top)
      <p style="margin:0 0 6px;"><strong>Top match:</strong> {{ $top->name }}</p>
      <p style="margin:0 0 6px;"><strong>Category:</strong> {{ $top->category }}</p>
      <p style="margin:0 0 6px;"><strong>Probability:</strong> {{ number_format($top->prob * 100, 1) }}%</p>
      <p style="margin:0 0 14px;"><strong>Recommendation:</strong> {{ $top->triage_level }}</p>
    @else
      <p>No result available.</p>
    @endif

    <hr style="border:none;border-top:1px solid #eee;margin:14px 0;">

    <h3 style="margin:0 0 8px;">Top 3</h3>
    <ol style="text-align:left;margin:0 0 12px 18px;">
      @foreach($top3 as $row)
        <li>{{ $row->name }} ({{ $row->category }}) — {{ number_format($row->prob * 100, 1) }}%</li>
      @endforeach
    </ol>

    <form method="POST" action="{{ route('session.restart') }}">
      @csrf
      <button class="btn" type="submit" style="width:100%;">Take Another Assessment</button>
    </form>
  </div>
@endsection