@extends('layout')

@section('content')
<div class="card" style="max-width:980px;text-align:left;">
  <h2 style="margin-top:0;">Questions</h2>

  @if(session('success')) <p style="color:green;">{{ session('success') }}</p> @endif

  <p><a href="{{ route('questions.create') }}">+ Add Question</a></p>

  <table border="1" cellpadding="8" cellspacing="0" style="width:100%;border-collapse:collapse;">
    <tr><th>ID</th><th>Code</th><th>Text</th><th>Active</th><th>Actions</th></tr>
    @foreach($questions as $q)
      <tr>
        <td>{{ $q->id }}</td>
        <td>{{ $q->code }}</td>
        <td>{{ $q->text }}</td>
        <td>{{ $q->is_active ? 'Yes' : 'No' }}</td>
        <td>
          <a href="{{ route('questions.edit', $q->id) }}">Edit</a>
          |
          <form method="POST" action="{{ route('questions.destroy', $q->id) }}" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" onclick="return confirm('Delete this question?')">Delete</button>
          </form>
        </td>
      </tr>
    @endforeach
  </table>
</div>
@endsection