@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: var(--ktvc-maroon);"><i class="fas fa-users-cog"></i> User Management</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email / Index No</th>
                            <th>Assigned Roles</th>
                            <th>Date Joined</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td class="fw-bold">{{ $user->name ?? 'Trainee Account' }}</td>
                                <td>{{ $user->email ?? $user->index_number }}</td>
                                <td>
                                    @forelse($user->roles as $role)
                                        <span class="badge {{ $role->name == 'Super Admin' ? 'bg-danger' : ($role->name == 'Registrar' ? 'bg-primary' : 'bg-secondary') }}">
                                            {{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="badge bg-light text-dark border">No Roles (Standard User)</span>
                                    @endforelse
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-dark">
                                        <i class="fas fa-edit"></i> Manage Roles
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection