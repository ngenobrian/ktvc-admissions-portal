@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2 style="color: var(--ktvc-maroon);"><i class="fas fa-users-cog"></i> Staff Management</h2>
        @if(auth()->user()->role === 'super_admin')
            <button class="btn btn-success fw-bold" data-toggle="modal" data-target="#addStaffModal">
                <i class="fas fa-plus"></i> Add New Staff
            </button>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 mt-3"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <ul class="nav nav-tabs mt-4">
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'active' ? 'active fw-bold text-primary' : 'text-muted' }}" 
               href="{{ route('admin.staff.index', ['tab' => 'active']) }}">Active Staff</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'archived' ? 'active fw-bold text-danger' : 'text-muted' }}" 
               href="{{ route('admin.staff.index', ['tab' => 'archived']) }}">Archived Staff</a>
        </li>
    </ul>

    <div class="card shadow-sm border-0 border-top-0 rounded-bottom">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staff as $member)
                        <tr>
                            <td><strong>{{ $member->name }}</strong></td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->phone_number }}</td>
                            <td>
                                <span class="badge bg-secondary text-uppercase">{{ str_replace('_', ' ', $member->role) }}</span>
                            </td>
                            <td class="text-end">
                                @if(auth()->user()->role === 'super_admin')
                                    @if($tab === 'active')
                                        <form action="{{ route('admin.staff.archive', $member->id) }}" method="POST" onsubmit="return confirm('Archive this user? They will lose login access.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-archive"></i> Archive</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.staff.restore', $member->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-undo"></i> Restore Access</button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addStaffModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">Add New User</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.staff.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Assign Role</label>
                            <select name="role" class="form-select" required>
                                <option value="admin">Admin (Full Dashboard Access)</option>
                                <option value="hod">H.O.D (View Statistics Only)</option>
                                <option value="staff">Standard Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-success fw-bold">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection