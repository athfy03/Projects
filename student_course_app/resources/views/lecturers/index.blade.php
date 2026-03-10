@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Lecturers</h3>
        <a href="{{ route('lecturers.create') }}" class="btn btn-primary">Add Lecturer</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Staff ID</th>
                <th>Email</th>
                <th width="220">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lecturers as $l)
                <tr>
                    <td>{{ $l->id }}</td>
                    <td>{{ $l->name }}</td>
                    <td>{{ $l->staff_id }}</td>
                    <td>{{ $l->email }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route('lecturers.show', $l) }}">View</a>
                        <a class="btn btn-sm btn-warning" href="{{ route('lecturers.edit', $l) }}">Edit</a>

                        <form class="d-inline" method="POST" action="{{ route('lecturers.destroy', $l) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this lecturer?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No records.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $lecturers->links() }}
</div>
@endsection
