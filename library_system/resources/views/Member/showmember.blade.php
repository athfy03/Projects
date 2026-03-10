@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Members Details</h1>

    <table class="table table-striped table-bordered w-auto">
        <tbody>
            <tr>
                <th style="width: 220px;">Name</th>
                <td>{{ $member->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $member->email }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $member->phone ?: '—' }}</td>
            </tr>
            <tr>
                <th>Membership</th>
                <td>{{ ucfirst($member->membership_type) }}</td>
            </tr>
            <tr>
                <th>Joined Date</th>
                <td>
                    @if ($member->joined_date)
                        {{ \Carbon\Carbon::parse($member->joined_date)->format('d M Y') }}
                    @else
                        —
                    @endif
                </td>
            </tr>
            <tr>
                <th>Expiry Date</th>
                <td>
                    @if ($member->expiry_date)
                        {{ \Carbon\Carbon::parse($member->expiry_date)->format('d M Y') }}
                    @else
                        —
                    @endif
                </td>
            </tr>
            <tr>
                <th>Created</th>
                <td>{{ optional($member->created_at)->format('d M Y, h:i A') }}</td>
            </tr>
            <tr>
                <th>Last Updated</th>
                <td>{{ optional($member->updated_at)->format('d M Y, h:i A') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="d-flex gap-2">
        <a href="{{ route('members.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('members.edit', $member) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('members.destroy', $member) }}" method="POST" onsubmit="return confirm('Delete this member?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>
@endsection