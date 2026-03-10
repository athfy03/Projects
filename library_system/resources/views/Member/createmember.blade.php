@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h1>Add New Member</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('members.store') }}" method="POST">
    @csrf

    {{-- Name --}}
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input
        id="name"
        type="text"
        name="name"
        class="form-control"
        value="{{ old('name') }}"
        required
      >
    </div>

    {{-- Email --}}
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input
        id="email"
        type="email"
        name="email"
        class="form-control"
        value="{{ old('email') }}"
        required
      >
    </div>

    {{-- Phone --}}
    <div class="mb-3">
      <label for="phone" class="form-label">Phone (optional)</label>
      <input
        id="phone"
        type="tel"
        name="phone"
        class="form-control"
        value="{{ old('phone') }}"
      >
    </div>

    {{-- Membership Type --}}
    <div class="mb-3">
      <label for="membership_type" class="form-label">Membership Type</label>
      <select
        id="membership_type"
        name="membership_type"
        class="form-control"
        required
      >
        <option value="standard" {{ old('membership_type') === 'standard' ? 'selected' : '' }}>Standard</option>
        <option value="premium"  {{ old('membership_type') === 'premium'  ? 'selected' : '' }}>Premium</option>
      </select>
    </div>

    {{-- Joined Date (required because DB column is NOT NULL) --}}
    <div class="mb-3">
      <label for="joined_date" class="form-label">Joined Date</label>
      <input
        id="joined_date"
        type="date"
        name="joined_date"
        class="form-control"
        value="{{ old('joined_date') ?? now()->toDateString() }}"
        required
      >
    </div>

    {{-- Expiry Date (optional) --}}
    <div class="mb-3">
      <label for="expiry_date" class="form-label">Expiry Date (optional)</label>
      <input
        id="expiry_date"
        type="date"
        name="expiry_date"
        class="form-control"
        value="{{ old('expiry_date') }}"
      >
      <small class="text-muted">Leave blank if membership has no expiry yet.</small>
    </div>

    <button type="submit" class="btn btn-success">Save</button>
    <a href="{{ route('members.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
