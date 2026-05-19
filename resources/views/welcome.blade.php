@extends('layouts.app')

@section('content')
<style>
    .homepage-hero {
        /* This creates the faded white overlay on top of your administration block image */
        background: linear-gradient(rgba(255, 255, 255, 0.85), rgba(255, 255, 255, 0.95)), url('{{ asset("images/administration-bg.jpg") }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 85vh;
        display: flex;
        align-items: center;
    }

    /* Styling the Auth Tabs to match the screenshot / KTVC Brand */
    .auth-tabs .nav-link {
        color: #6c757d;
        border: 1px solid #dee2e6;
        border-radius: 20px;
        padding: 5px 20px;
        margin: 0 5px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .auth-tabs .nav-link.active {
        background-color: #C89D3C !important; /* KTVC Gold */
        color: #fff !important;
        border-color: #C89D3C !important;
    }
    
    .auth-card {
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        background: #ffffff;
    }
</style>

<div class="homepage-hero py-5">
    <div class="container">
        <div class="row align-items-center">
            
            <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0 pe-lg-5">
                
                <img src="{{ asset('images/ktvc-navbar-logo.png') }}" alt="Kipkabus TVC Logo" class="img-fluid mb-4" style="max-height: 120px;">
                
                <h2 class="fw-bold mb-5" style="color: #1a2530; letter-spacing: 1px;">MAY 2026 INTAKE OPEN</h2>
                
                <div class="mb-5">
                    <h6 class="fw-bold text-dark mb-3">: Contact Details :</h6>
                    <p class="mb-1 text-muted">P.O BOX 10882-30100, Eldoret, Kenya</p>
                    <p class="mb-1 text-muted"><span style="color: #C89D3C;">Email:</span> info@ktvc.ac.ke</p>
                    <p class="mb-1 text-muted"><span style="color: #C89D3C;">Tel:</span> 0717 130 180</p>
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3">
                    
                    <a href="{{ asset('downloads/ktvc-course-bronchure.pdf') }}" class="btn btn-outline-dark shadow-sm py-2 px-4 rounded-pill" target="_blank" rel="noopener noreferrer">
                        <i class="fas fa-file-pdf text-danger me-2"></i> Ktvc Course Brochure
                    </a>
                    
                    <a href="{{ asset('downloads/ktvc-fee-structure.pdf') }}" class="btn btn-outline-dark shadow-sm py-2 px-4 rounded-pill" target="_blank" rel="noopener noreferrer">
                        <i class="fas fa-coins text-warning me-2"></i> Ktvc Fee Structure
                    </a>
                    
                </div>
            </div>

            <div class="col-lg-6">
                <div class="auth-card p-4 p-md-5 mx-auto" style="max-width: 550px;">
                    
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/ktvc-navbar-logo.png') }}" alt="KTVC" style="max-height: 50px;">
                    </div>

                    <ul class="nav nav-pills auth-tabs justify-content-center mb-4" id="authTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="register-tab" data-bs-toggle="pill" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="true">REGISTER</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="login-tab" data-bs-toggle="pill" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="false">LOGIN</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="authTabsContent">
                        
                        <div class="tab-pane fade show active" id="register" role="tabpanel" aria-labelledby="register-tab">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label small fw-bold text-muted">Email Address</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold text-muted">Password</label>
                                        <input type="password" name="password" placeholder="minimum 8 characters" class="form-control" required>
                                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label small fw-bold text-muted">Confirm Password</label>
                                        <input type="password" name="password_confirmation" placeholder="retype your password" class="form-control" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn w-100 fw-bold py-2" style="background-color: #1a2b4c; color: white;">
                                    REGISTER ACCOUNT
                                </button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Email / Index Number</label>
                                    <input type="text" name="login_id" class="form-control" placeholder="e.g. info@domain.com or 12345678" required>
                                    @error('login_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-muted">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label small text-muted" for="remember">Remember Me</label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="small text-decoration-none" style="color: #7B1818;">Forgot Password?</a>
                                </div>
                                <button type="submit" class="btn w-100 fw-bold py-2" style="background-color: #1a2b4c; color: white;">
                                    SECURE LOGIN
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection