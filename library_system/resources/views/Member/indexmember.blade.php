@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Members</h1>

    <a href="{{ route('members.create') }}" class="btn btn-primary mb-3">Add New Member</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Membership Type</th>
                <th>Joined Date</th>
                <th>Expiry Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone ?: '—' }}</td>
                    <td>{{ ucfirst($member->membership_type) }}</td>
                    <td>
                        @if($member->joined_date)
                            {{ \Carbon\Carbon::parse($member->joined_date)->format('d M Y') }}
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        @if($member->expiry_date)
                            {{ \Carbon\Carbon::parse($member->expiry_date)->format('d M Y') }}
                        @else
                            —
                        @endif
                    </td>
                    <td class="text-nowrap">
                        <a href="{{ route('members.show', $member) }}" class="btn btn-info btn-sm">Details</a>
                        <a href="{{ route('members.edit', $member) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('members.destroy', $member) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this member?')" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Optional: pagination --}}
    {{-- {{ $members->links() }} --}}
</div>
@endsection