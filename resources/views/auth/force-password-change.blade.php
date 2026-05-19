@extends('layouts.app') @section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0" style="border-top: 4px solid var(--ktvc-maroon) !important;">
                <div class="card-header bg-white text-center py-4">
                    <h4 class="fw-bold text-danger mb-0"><i class="fas fa-shield-alt"></i> Action Required</h4>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted text-center mb-4">For security reasons, you must change your default password before accessing the KTVC system.</p>

                    <form method="POST" action="{{ route('password.force.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">New Password</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger fw-bold py-2">Secure Account & Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection