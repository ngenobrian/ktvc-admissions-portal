@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: var(--ktvc-maroon);"><i class="fas fa-user-shield"></i> Manage Staff Roles</h2>
        @if(auth()->user()->role === 'super_admin')
            <button class="btn btn-success fw-bold" data-toggle="modal" data-target="#addRoleModal">
                <i class="fas fa-plus"></i> Create New Role
            </button>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm border-0"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Role Name</th>
                        <th>Assigned Permissions</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td><strong>{{ ucfirst($role->name) }}</strong></td>
                            <td>
                                @if($role->name === 'super_admin')
                                    <span class="badge bg-success">All Access</span>
                                @elseif($role->permissions)
                                    @foreach($role->permissions as $perm)
                                        <span class="badge bg-light text-dark border mb-1">{{ ucwords(str_replace('_', ' ', $perm)) }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted small">No permissions assigned</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($role->name !== 'super_admin')
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Delete this role? Users assigned to this role will lose their permissions.');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-4 text-muted">No custom roles created yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">Create System Role</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Role Title</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., Department Head, Admissions Clerk" required>
                        </div>

                        <div class="border-top pt-3">
                            <h5 class="fw-bold mb-3">System Access Permissions</h5>
                            <p class="text-muted small mb-3">Select the specific modules this user is allowed to access within the system.</p>
                            
                            <div class="row">
                                @foreach($availablePermissions as $key => $label)
                                    <div class="col-md-4 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input border-secondary" type="checkbox" name="permissions[]" value="{{ $key }}" id="perm_{{ $key }}">
                                            <label class="form-check-label" for="perm_{{ $key }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success fw-bold">Save Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection