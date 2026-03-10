@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Edit Member</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Update goes to members.update (PUT) --}}
    <form action="{{ route('members.update', $member) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input
                id="name"
                type="text"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $member->name) }}"
                required
            >
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $member->email) }}"
                required
            >
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone (optional)</label>
            <input
                id="phone"
                type="tel"
                name="phone"
                class="form-control @error('phone') is-invalid @enderror"
                value="{{ old('phone', $member->phone) }}"
            >
            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="membership_type" class="form-label">Membership Type</label>
            <select
                id="membership_type"
                name="membership_type"
                class="form-control @error('membership_type') is-invalid @enderror"
                required
            >
                <option value="standard" {{ old('membership_type', $member->membership_type) == 'standard' ? 'selected' : '' }}>Standard</option>
                <option value="premium"  {{ old('membership_type', $member->membership_type) == 'premium'  ? 'selected' : '' }}>Premium</option>
            </select>
            @error('membership_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="joined_date" class="form-label">Joined Date</label>
            <input
                id="joined_date"
                type="date"
                name="joined_date"
                class="form-control @error('joined_date') is-invalid @enderror"
                value="{{ old('joined_date', optional($member->joined_date)->format('Y-m-d')) }}"
                required
            >
            @error('joined_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="expiry_date" class="form-label">Expiry Date (optional)</label>
            <input
                id="expiry_date"
                type="date"
                name="expiry_date"
                class="form-control @error('expiry_date') is-invalid @enderror"
                value="{{ old('expiry_date', optional($member->expiry_date)->format('Y-m-d')) }}"
            >
            @error('expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('members.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection