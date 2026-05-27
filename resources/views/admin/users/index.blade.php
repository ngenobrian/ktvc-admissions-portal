@extends('layouts.admin')

@section('content')
<!--new section -->
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2 style="color: var(--ktvc-maroon);"><i class="fas fa-users-cog"></i> User Management</h2>
        
        @if(auth()->user()->role === 'super_admin')
            <a href="{{ route('admin.users.create') }}" class="btn btn-success fw-bold">
                <i class="fas fa-plus"></i> Add New User
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 mt-3"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <ul class="nav nav-tabs mt-4">
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'active' ? 'active fw-bold text-primary' : 'text-muted' }}" 
               href="{{ route('admin.users.index', ['tab' => 'active']) }}">Active Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'archived' ? 'active fw-bold text-danger' : 'text-muted' }}" 
               href="{{ route('admin.users.index', ['tab' => 'archived']) }}">Archived Users</a>
        </li>
    </ul>

    <div class="card shadow-sm border-0 border-top-0 rounded-bottom">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Date Joined</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $users->firstItem() + $loop->index }}</td>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number ?? 'N/A' }}</td>
                                
                                <td>
                                    @if($user->role)
                                        <span class="badge {{ $user->role === 'super_admin' ? 'bg-danger' : 'bg-primary' }} text-uppercase">
                                            {{ str_replace('_', ' ', $user->role) }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-dark border">No Roles (Standard User)</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td class="text-end">
                                    @if(auth()->user()->role === 'super_admin')
                                        @if($tab === 'active')
                                            <div class="d-flex justify-content-evenly gap-2">
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.users.archive', $user->id) }}" method="POST" onsubmit="return confirm('Archive this user? They will lose login access.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-archive"></i> Archive</button>
                                                </form>
                                            </div>
                                        @else
                                            <form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-undo"></i> Restore Access</button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-users-slash fa-2x mb-2"></i><br>
                                    No {{ $tab }} users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $users->appends(['tab' => $tab])->links() }}</div>
    </div>
</div>
<!-- end of new section -->
@endsection