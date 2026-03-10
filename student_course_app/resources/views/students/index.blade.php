@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Students</h3>
        <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th><th>Name</th><th>Matric No</th><th>Email</th><th width="220">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $s)
            <tr>
                <td>{{ $s->id }}</td>
                <td>{{ $s->name }}</td>
                <td>{{ $s->matric_no }}</td>
                <td>{{ $s->email }}</td>
                <td>
                    <a class="btn btn-sm btn-info" href="{{ route('students.show',$s) }}">View</a>
                    <a class="btn btn-sm btn-warning" href="{{ route('students.edit',$s) }}">Edit</a>
                    <form class="d-inline" method="POST" action="{{ route('students.destroy',$s) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5">No records.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $students->links() }}
</div>
@endsection
