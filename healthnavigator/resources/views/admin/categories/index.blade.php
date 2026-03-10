@extends('layout')

@section('content')
<div class="card" style="max-width:900px;text-align:left;">
  <h2 style="margin-top:0;">Categories</h2>

  @if(session('success')) <p style="color:green;">{{ session('success') }}</p> @endif

  <p><a href="{{ route('categories.create') }}">+ Add Category</a></p>

  <table border="1" cellpadding="8" cellspacing="0" style="width:100%;border-collapse:collapse;">
    <tr><th>ID</th><th>Name</th><th>Label</th><th>Actions</th></tr>
    @foreach($categories as $c)
      <tr>
        <td>{{ $c->id }}</td>
        <td>{{ $c->name }}</td>
        <td>{{ $c->label }}</td>
        <td>
          <a href="{{ route('categories.edit', $c->id) }}">Edit</a>
          |
          <form method="POST" action="{{ route('categories.destroy', $c->id) }}" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" onclick="return confirm('Delete this category?')">Delete</button>
          </form>
        </td>
      </tr>
    @endforeach
  </table>
</div>
@endsection