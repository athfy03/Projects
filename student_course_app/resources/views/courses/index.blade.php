@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Courses</h3>
        <a href="{{ route('courses.create') }}" class="btn btn-primary">Add Course</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>Title</th>
                <th>Credit Hour</th>
                <th width="220">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->code }}</td>
                    <td>{{ $c->title }}</td>
                    <td>{{ $c->credit_hour }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route('courses.show', $c) }}">View</a>
                        <a class="btn btn-sm btn-warning" href="{{ route('courses.edit', $c) }}">Edit</a>

                        <form class="d-inline" method="POST" action="{{ route('courses.destroy', $c) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this course?')">
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

    {{ $courses->links() }}
</div>
@endsection
