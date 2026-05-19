@extends('layouts.admin')

@section('content')
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

                        <div class="mb-4">
                            <label class="form-label fw-bold mb-3">System Roles</label>
                            
                            @foreach($roles as $role)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}"
                                        {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                        @if($role->name == 'Super Admin')
                                            <small class="text-danger d-block">Full system access, including system settings and staff management.</small>
                                        @elseif($role->name == 'Registrar')
                                            <small class="text-muted d-block">Can view, approve, and reject trainee applications.</small>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
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