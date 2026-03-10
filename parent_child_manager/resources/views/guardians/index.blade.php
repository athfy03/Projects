@extends('layout')

@section('content')

<h1>Guardians List</h1>

<a class="btn btn-blue" href="{{ route('guardians.create') }}">➕ Add New Guardian</a>
<a class="btn btn-grey" href="{{ url('/') }}">🏠 Back to Home</a>

<!-- SEARCH BAR -->
<form method="GET" action="{{ route('guardians.index') }}" class="search-box">
    <input type="text" name="search" placeholder="Search guardians..." value="{{ $search }}">
</form>

<table>
    <tr>
        <th class="col-small">No.</th>
        <th class="col-auto">Father</th>
        <th class="col-auto">Mother</th>
        <th class="col-medium">Contact</th>
        <th class="actions-col">Actions</th>
    </tr>


    @foreach ($guardians as $g)
    <tr>
        <td class="col-small">{{ $loop->iteration }}</td>
        <td class="col-auto">{{ $g->father_name }}</td>
        <td class="col-auto">{{ $g->mother_name }}</td>
        <td class="col-medium">{{ $g->contact_number }}</td>

        <td class="actions-col">
            <a class="btn btn-blue btn-sm" href="{{ route('guardians.show', $g->id) }}">👁 Show</a>
            <a class="btn btn-yellow btn-sm" href="{{ route('guardians.edit', $g->id) }}">✏ Edit</a>

            <form method="POST" action="{{ route('guardians.destroy', $g->id) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-red btn-sm" type="submit">🗑 Delete</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

<!-- PAGINATION -->
<div class="pagination">
    {{ $guardians->links() }}
</div>

@endsection
