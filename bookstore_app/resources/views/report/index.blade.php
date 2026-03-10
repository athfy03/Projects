@extends('layouts.app')

@section('content')
<h4 class="mb-3">Report</h4>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Total Books</h6>
                <h3 class="mb-0">{{ $totalBooks }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Total Authors</h6>
                <h3 class="mb-0">{{ $totalAuthors }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Total Categories</h6>
                <h3 class="mb-0">{{ $totalCategories }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Authors and Number of Books Written</div>
    <div class="card-body table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Author</th>
                    <th>Email</th>
                    <th>Books Written</th>
                </tr>
            </thead>
            <tbody>
                @forelse($authors as $a)
                    <tr>
                        <td>{{ $a->id }}</td>
                        <td>{{ $a->name }}</td>
                        <td>{{ $a->email }}</td>
                        <td>{{ $a->books_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No authors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
