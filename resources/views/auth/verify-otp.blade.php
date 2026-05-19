@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0 mt-5">
                <div class="card-header card-header-ktvc text-center py-3">
                    <h4 class="mb-0"><i class="fas fa-envelope-open-text"></i> Verify Your Email</h4>
                </div>
                <div class="card-body p-4 text-center">
                    
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <p class="text-muted mb-4">We sent a 6-digit verification code to <strong>{{ auth()->user()->email }}</strong>. Please enter it below to activate your account.</p>

                    <form method="POST" action="{{ route('otp.verify') }}">
                        @csrf
                        <div class="mb-4">
                            <input type="text" class="form-control form-control-lg text-center fw-bold @error('otp') is-invalid @enderror" 
                                   id="otp" name="otp" maxlength="6" placeholder="------" 
                                   style="font-size: 2rem; letter-spacing: 15px;" required autofocus>
                            @error('otp')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-ktvc-accent py-2 fw-bold text-dark">
                                Verify Code <i class="fas fa-check-circle"></i>
                            </button>
                        </div>
                    </form>

                    <div class="mt-4">
                        <p class="mb-1">Didn't receive the code?</p>
                        <form method="POST" action="{{ route('otp.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline" style="color: var(--ktvc-maroon); font-weight: bold;">
                                Click here to resend
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection