@extends('layout')

@section('content')

<h1>Children List</h1>

<a class="btn btn-blue" href="{{ route('children.create') }}">➕ Add New Child</a>
<a class="btn btn-grey" href="{{ url('/') }}">🏠 Back to Home</a>

<!-- SEARCH BAR -->
<form method="GET" action="{{ route('children.index') }}" class="search-box">
    <input type="text" name="search" placeholder="Search children..." value="{{ $search }}">
</form>

<table>
    <tr>
        <th class="col-small">No.</th>
        <th class="col-auto">Name</th>
        <th class="col-small">Age</th>
        <th class="col-auto">Guardian</th>
        <th class="actions-col">Actions</th>
    </tr>

    @foreach ($children as $child)
    <tr>
        <td class="col-small">{{ $loop->iteration }}</td>
        <td class="col-auto">{{ $child->name }}</td>
        <td class="col-small">{{ $child->age }}</td>
        <td class="col-auto">{{ $child->guardian->father_name }} & {{ $child->guardian->mother_name }}</td>

        <td class="actions-col">
            <a class="btn btn-blue btn-sm" href="{{ route('children.show', $child->id) }}">👁 Show</a>
            <a class="btn btn-yellow btn-sm" href="{{ route('children.edit', $child->id) }}">✏ Edit</a>

            <form method="POST" action="{{ route('children.destroy', $child->id) }}" style="display:inline;">
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
    {{ $children->links() }}
</div>

@endsection
