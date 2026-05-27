@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary btn-sm mb-3">
            <i class="fas fa-arrow-left"></i> Back to Roles
        </a>
        <h3 style="color: var(--ktvc-maroon);"><i class="fas fa-user-edit"></i> Edit Role: {{ ucfirst($role->name) }}</h3>
    </div>

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

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4 w-50">
                    <label class="form-label fw-bold">Role Title</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                </div>

                <div class="border-top pt-4">
                    <h5 class="fw-bold mb-3">System Access Permissions</h5>
                    <p class="text-muted small mb-4">Check or uncheck the modules this role is allowed to access.</p>
                    
                    <div class="row">
                        @foreach($availablePermissions as $key => $label)
                            <div class="col-md-4 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input border-secondary" type="checkbox" 
                                           name="permissions[]" 
                                           value="{{ $key }}" 
                                           id="perm_{{ $key }}"
                                           {{ (is_array($role->permissions) && in_array($key, $role->permissions)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_{{ $key }}">
                                        {{ $label }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr class="mt-4 mb-4">

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success px-4 fw-bold">Update Role</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection