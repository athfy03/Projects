@extends('layout')

@section('content')
<div class="card" style="max-width:980px;text-align:left;">
  <h2 style="margin-top:0;">Conditions</h2>

  @if(session('success')) <p style="color:green;">{{ session('success') }}</p> @endif

  <p><a href="{{ route('conditions.create') }}">+ Add Condition</a></p>

  <table border="1" cellpadding="8" cellspacing="0" style="width:100%;border-collapse:collapse;">
    <tr><th>ID</th><th>Category</th><th>Name</th><th>Slug</th><th>Triage</th><th>Prior</th><th>Actions</th></tr>
    @foreach($conditions as $c)
      <tr>
        <td>{{ $c->id }}</td>
        <td>{{ $c->category_label }}</td>
        <td>{{ $c->name }}</td>
        <td>{{ $c->slug }}</td>
        <td>{{ $c->triage_level }}</td>
        <td>{{ $c->prior }}</td>
        <td>
          <a href="{{ route('conditions.edit', $c->id) }}">Edit</a>
          |
          <form method="POST" action="{{ route('conditions.destroy', $c->id) }}" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" onclick="return confirm('Delete this condition?')">Delete</button>
          </form>
        </td>
      </tr>
    @endforeach
  </table>
</div>
@endsection