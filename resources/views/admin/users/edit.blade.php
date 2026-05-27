@extends('layouts.admin')

@section('content')
@if ($errors->any())
        <div class="alert alert-danger shadow-sm border-0 mt-3">
            <h6 class="fw-bold mb-1"><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm mb-3">
            <i class="fas fa-arrow-left"></i> Back to Users
        </a>
        <h3 style="color: var(--ktvc-maroon);">Manage Roles: {{ $user->name ?? $user->index_number }}</h3>
        <p class="text-muted">Assign or revoke administrative privileges for this user.</p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
    <label class="form-label fw-bold">Assign System Role</label>
    <select name="role" class="form-select" required>
        <option value="">-- Select a Role --</option>
        
        @if(auth()->user()->role === 'super_admin')
            <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
        @endif

        @foreach($roles as $role)
            <option value="{{ $role->name }}" {{ $user->role === $role->name ? 'selected' : '' }}>
                {{ ucfirst($role->name) }}
            </option>
        @endforeach
    </select>
</div>

                        <hr>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-ktvc-primary px-4 fw-bold">Save Role Assignments</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection