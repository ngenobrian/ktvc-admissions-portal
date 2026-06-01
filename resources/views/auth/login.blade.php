@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0 mt-5">
                <div class="card-header card-header-ktvc text-center py-3">
                    <h4 class="mb-0"><i class="fas fa-sign-in-alt"></i> Portal Login</h4>
                </div>
                <div class="card-body p-4">
                    
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Login ID (Email OR Index Number) -->
                        <div class="mb-3">
                            <label for="login_id" class="form-label fw-bold">Email Address</label>
                            <input type="text" class="form-control @error('login_id') is-invalid @enderror" id="login_id" name="login_id" value="{{ old('login_id') }}" required autofocus placeholder="e.g. email@example.com OR 123456789/2025">
                            @error('login_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                            
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>
                            <a href="#" style="color: var(--ktvc-maroon); font-size: 0.9rem;">Forgot Password?</a>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-ktvc-primary py-2 fw-bold">
                                Login <i class="fas fa-unlock-alt"></i>
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <p>Don't have an account? <a href="{{ route('register') }}" style="color: var(--ktvc-gold); font-weight: bold;">Apply Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection