@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0 mt-5">
                <div class="card-header card-header-ktvc text-center py-3">
                    <h4 class="mb-0"><i class="fas class fa-user-plus"></i> Create an Account</h4>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted text-center mb-4">For Self-Sponsored Students Only.</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="your.email@example.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Minimum 8 characters">
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Retype your password">
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-ktvc-accent py-2 fw-bold text-dark">
                                Register Account <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-4 text-center">
                        <p>Already have an account? <a href="{{ route('login') }}" style="color: var(--ktvc-maroon); font-weight: bold;">Login Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection