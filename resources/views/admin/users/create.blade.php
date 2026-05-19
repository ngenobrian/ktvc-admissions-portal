@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm mb-3">
            <i class="fas fa-arrow-left"></i> Back to Staff List
        </a>
        <h3 style="color: var(--ktvc-maroon);">Register New Administrator / Staff</h3>
    </div>
    
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <h5 class="fw-bold mb-3 border-bottom pb-2">1. Personal & Contact Details</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control" required>
                    </div>
                </div>

                <h5 class="fw-bold mb-3 mt-4 border-bottom pb-2">2. Institutional Roles</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Job Title (e.g., HOD, Finance Officer)</label>
                        <input type="text" name="job_title" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Department</label>
                        <select name="department" class="form-select form-control" required>
                            <option value="" disabled selected>Select Department...</option>
                            <option value="Administration">Administration</option>
                            <option value="Building & Civil Engineering">Building & Civil Engineering</option>
                            <option value="Computing & Informatics">Computing & Informatics</option>
                            <option value="Electrical & Electronics Engineering">Electrical & Electronics Engineering</option>
                            <option value="Mechanical & Automotive Engineering">Mechanical & Automotive Engineering</option>
                            <option value="Hospitality, Fashion & Design">Hospitality, Fashion & Design</option>
                            <option value="Business and Liberal Studies">Business and Liberal Studies</option>
                        </select>
                    </div>
                </div>

                <h5 class="fw-bold mb-3 mt-4 border-bottom pb-2">3. System Access Permissions</h5>
                <p class="text-muted small mb-3">Select the specific modules this user is allowed to access within the system.</p>
                
                <div class="row">
                    @foreach($permissions as $permission)
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                <label class="form-check-label text-capitalize" for="perm_{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="alert alert-warning mt-4 border-0 shadow-sm">
                    <i class="fas fa-lock"></i> Security Notice: Upon creation, this user will be assigned the default password <strong>Password@2026</strong>. The system will force them to change it immediately upon their first login.
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success fw-bold px-4 py-2">
                        <i class="fas fa-save"></i> Create Staff Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection