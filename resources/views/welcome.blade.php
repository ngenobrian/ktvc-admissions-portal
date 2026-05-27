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
                    <div style="margin-top: 1.5rem;">
    <h4 style="margin-bottom: 10px; font-weight: 600; color: #333;">Connect With Us</h4>
    <div style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">
        
        <a href="https://facebook.com/KipkabusTVC" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #1877F2; font-weight: 500; transition: opacity 0.2s;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
            </svg>
            <span>@KipkabusTVC</span>
        </a>

        <a href="https://instagram.com/kipkabustvc" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #E1306C; font-weight: 500; transition: opacity 0.2s;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
            </svg>
            <span>@kipkabustvc</span>
        </a>

        <a href="https://x.com/kipkabustvc" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #000000; font-weight: 500; transition: opacity 0.2s;">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
            </svg>
            <span>@kipkabustvc</span>
        </a>

        <a href="https://tiktok.com/@kipkabustvc" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #000000; font-weight: 500; transition: opacity 0.2s;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
            </svg>
            <span>@kipkabustvc</span>
        </a>

    </div>
</div>
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
                                    <label class="form-label small fw-bold text-muted">Email</label>
                                    <input type="text" name="login_id" class="form-control" placeholder="e.g. info@domain.com" required>
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
                                    LOGIN
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