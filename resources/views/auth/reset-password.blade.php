@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 75vh; display: flex; align-items: center;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0" style="border-top: 4px solid var(--ktvc-maroon, #7B1818);">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <i class="fas fa-key fs-1 mb-3" style="color: #C89D3C;"></i>
                        <h4 class="fw-bold text-dark">Create New Password</h4>
                        <p class="text-muted small">Please enter and confirm your new secure password below.</p>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" required readonly>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">New Password</label>
                            <input type="password" name="password" class="form-control" required autofocus>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn w-100 fw-bold py-2" style="background-color: var(--ktvc-maroon, #7B1818); color: white;">
                            Reset Password
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection