@extends('layouts.app') @section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="text-center mb-4">
                <h1 class="fw-bold" style="color: var(--ktvc-maroon);">Contact KTVC Admissions</h1>
                <p class="text-muted">Do you have a question about our courses, intakes, or application process? Send us a message and we will get back to you shortly.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success shadow-sm border-0 mb-4">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="card shadow-sm border-0" style="border-top: 4px solid var(--ktvc-maroon) !important;">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('enquiry.submit') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" 
                                    value="{{ auth()->check() ? auth()->user()->name : old('name') }}" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" 
                                    value="{{ auth()->check() ? auth()->user()->email : old('email') }}" required>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone Number (Optional)</label>
                            <input type="text" name="phone_number" class="form-control" 
                                value="{{ auth()->check() ? (auth()->user()->application->phone_number ?? '') : old('phone_number') }}">
                            @error('phone_number') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Your Enquiry <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control" rows="6" placeholder="How can we help you?" required>{{ old('message') }}</textarea>
                            @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-ktvc-primary fw-bold py-2" style="background-color: #7B1818; color: white;">
                                <i class="fas fa-paper-plane me-2"></i> Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-5 text-center">
                <div class="col-md-4 mb-3">
                    <i class="fas fa-map-marker-alt fs-3 mb-2" style="color: var(--ktvc-maroon);"></i>
                    <h6 class="fw-bold">Location</h6>
                    <p class="text-muted small">P.O BOX 10882-30100<br>Eldoret</p>
                </div>
                <div class="col-md-4 mb-3">
                    <i class="fas fa-phone-alt fs-3 mb-2" style="color: var(--ktvc-maroon);"></i>
                    <h6 class="fw-bold">Phone / WhatsApp</h6>
                    <p class="text-muted small">0717 130 180</p>
                </div>
                <div class="col-md-4 mb-3">
                    <i class="fas fa-envelope fs-3 mb-2" style="color: var(--ktvc-maroon);"></i>
                    <h6 class="fw-bold">Email</h6>
                    <p class="text-muted small">info@ktvc.ac.ke</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection