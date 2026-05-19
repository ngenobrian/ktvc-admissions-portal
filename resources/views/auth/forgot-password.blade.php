@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 75vh; display: flex; align-items: center;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0" style="border-top: 4px solid var(--ktvc-maroon, #7B1818);">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <i class="fas fa-unlock-alt fs-1 mb-3" style="color: #C89D3C;"></i>
                        <h4 class="fw-bold text-dark">Forgot Password?</h4>
                        <p class="text-muted small">No problem. Just let us know your email address and we will email you a password reset link.</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success small"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your registered email" required autofocus>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <button type="submit" class="btn w-100 fw-bold py-2 mb-3" style="background-color: #1a2b4c; color: white;">
                            Email Password Reset Link
                        </button>
                        
                        <div class="text-center">
                            <a href="{{ url('/') }}" class="text-decoration-none small text-muted"><i class="fas fa-arrow-left"></i> Back to Login</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection