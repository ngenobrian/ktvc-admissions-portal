@extends('layouts.app')

@section('content')
<!-- Persistent Missing Profile Picture Warning -->
    @if(!auth()->user()->profile_picture)
        <div class="alert alert-warning shadow-sm border-0 mb-4 d-flex align-items-center">
            <i class="fas fa-exclamation-triangle fs-4 me-3 mr-3"></i> 
            <div>
                <strong>Action Required:</strong> You have not uploaded a profile picture yet. Please click the camera icon next to your name to upload a passport-style photo.
            </div>
        </div>
    @endif

    <!-- General Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 mb-4">{{ session('success') }}</div>
    @endif

    
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 style="color: var(--ktvc-maroon);">Student Dashboard</h2>
            <hr style="border-color: var(--ktvc-gold); border-width: 3px; width: 100px;">
        </div>
    </div>
    @if (session('error'))
        <div class="alert alert-danger shadow-sm border-0 mb-4">
            <i class="fas fa-exclamation-circle"></i> <strong>Error:</strong> {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <!-- Welcome Banner with Profile Picture -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4 d-flex align-items-center">
            
            <!-- Profile Picture (Clickable to trigger modal) -->
            <div class="position-relative mr-4 me-4" style="cursor: pointer;" data-toggle="modal" data-target="#profilePicModal" data-bs-toggle="modal" data-bs-target="#profilePicModal" title="Click to change profile picture">
                
                @if(auth()->user()->profile_picture)
                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                         alt="Profile Picture" 
                         class="rounded-circle shadow-sm border" 
                         style="width: 100px; height: 100px; object-fit: cover; border-width: 3px !important; border-color: var(--ktvc-maroon) !important;">
                @else
                    <div class="rounded-circle shadow-sm border d-flex align-items-center justify-content-center bg-light" 
                         style="width: 100px; height: 100px; border-width: 3px !important; border-color: #ccc !important;">
                        <i class="fas fa-camera text-secondary" style="font-size: 2.5rem;"></i>
                    </div>
                @endif
                
                <!-- Small pencil icon overlay to hint that it's clickable -->
                <div class="position-absolute bg-dark text-white rounded-circle d-flex align-items-center justify-content-center shadow" 
                     style="width: 30px; height: 30px; bottom: 0; right: 0; border: 2px solid white;">
                    <i class="fas fa-pencil-alt" style="font-size: 12px;"></i>
                </div>
            </div>

            <!-- Welcome Text -->
            <div>
                <h2 style="color: var(--ktvc-maroon); margin-bottom: 0;">Welcome, {{ auth()->user()->name ?? 'Trainee' }}!</h2>
                <p class="text-muted mb-0 fs-5">Trainee Admissions Portal</p>
            </div>

        </div>
    </div>
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <!-- <h4 class="card-title">Welcome, {{ auth()->user()->name }}!</h4> -->
                    <p class="text-muted">Use this portal to manage your admission to Kipkabus Technical and Vocational College.</p>
                    
                    <div class="mt-4 border p-3 rounded bg-light">
                        <h5>Application Status: 
                            @if($application->status == 'draft')
                                <span class="badge bg-secondary">Incomplete</span>
                            @elseif($application->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending Approval</span>
                            @elseif($application->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($application->status == 'rejected')
                            <div class="alert alert-danger mt-3 border-danger shadow-sm">
                                <h5 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle"></i> Application Returned</h5>
                                <p>Your application could not be approved at this time for the following reason:</p>
                                <hr>
                                <p class="mb-0 fw-bold text-dark bg-white p-2 rounded border">{{ $application->rejection_reason }}</p>
                            </div>
                            
                            <p class="mt-3 text-muted">Please correct the issues mentioned above and resubmit your application.</p>
                            <a href="{{ route('application.form') }}" class="btn btn-danger fw-bold mt-2">
                                <i class="fas fa-edit"></i> Edit & Resubmit Application
                            </a>
                        @endif
                        </h5>

                        @if($application->status == 'draft')
                            <p class="mt-3">You have not completed your application yet. Please fill in all the required particulars to submit your application to the Registrar.</p>
                            <a href="{{ route('application.form') }}" class="btn btn-ktvc-accent fw-bold text-dark mt-2">
                                <i class="fas fa-edit"></i> Complete Application Form
                            </a>
                        @elseif($application->status == 'pending')
                            <p class="mt-3">Your application has been submitted successfully. You will receive an email and SMS alert once the Registrar has reviewed it.</p>
                        @elseif($application->status == 'approved')
                            <p class="mt-3 text-success fw-bold">Congratulations! Your application has been approved.</p>
                            <a href="{{ route('application.letter.download') }}" class="btn btn-danger fw-bold mt-2 py-2 px-4 shadow-sm">
                            <i class="fas fa-file-pdf"></i> Download Admission Letter
                            </a>
                            <div class="card shadow-sm border-0 mt-4" style="border-top: 4px solid var(--ktvc-maroon) !important;">
        <div class="card-header bg-light border-bottom-0 pt-3 pb-2">
            <h4 class="fw-bold mb-0" style="color: var(--ktvc-maroon);">
                <i class="fas fa-clipboard-list me-2 mr-2"></i> Next Steps
            </h4>
        </div>
        <div class="card-body">
            <p class="text-muted mb-4">Please complete the following requirements before your official reporting date.</p>
            
            <ul class="list-group list-group-flush">
                
                <!-- Step 1: Print & Sign -->
                <li class="list-group-item px-0 py-3 border-bottom">
                    <div class="d-flex align-items-start">
                        <div class="mt-1 me-3 mr-3 text-secondary">
                            <i class="fas fa-print fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">1. Print and Sign</h6>
                            <p class="mb-0 text-dark">
                                After downloading the admission letter, print a copy and ensure you have signed where applicable, together with your parent/guardian where required.
                            </p>
                        </div>
                    </div>
                </li>
                
                <!-- Step 2: Medical Form -->
                <li class="list-group-item px-0 py-3 border-bottom">
                    <div class="d-flex align-items-start">
                        <div class="mt-1 me-3 mr-3 text-secondary">
                            <i class="fas fa-stethoscope fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">2. Medical Examination</h6>
                            <p class="mb-1 text-dark">
                                Ensure the medical examination form included in the Admission Letter has been duly filled by a registered doctor.
                            </p>
                            <small class="text-danger fw-bold">
                                <i class="fas fa-info-circle"></i> Note: Payment for examination and treatment is the responsibility of the applicant.
                            </small>
                        </div>
                    </div>
                </li>

                <!-- Step 3: Required Documents -->
                <li class="list-group-item px-0 py-3">
                    <div class="d-flex align-items-start">
                        <div class="mt-1 me-3 mr-3 text-secondary">
                            <i class="fas fa-folder-open fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-2">3. Required Documents for Reporting Date</h6>
                            <p class="mb-2 text-dark">Ensure that you have the following documents ready when you arrive on campus:</p>
                            
                            <ul class="list-unstyled mb-0" style="line-height: 1.8;">
                                <li><i class="fas fa-check text-success me-2 mr-2"></i> Duly filled Admission form</li>
                                <li><i class="fas fa-check text-success me-2 mr-2"></i> National ID Card (original and copy) / Passport / Proof of identity</li>
                                <li><i class="fas fa-check text-success me-2 mr-2"></i> Copy of Birth Certificate</li>
                                <li><i class="fas fa-check text-success me-2 mr-2"></i> Two (2) recent passport size photos</li>
                                <li><i class="fas fa-check text-success me-2 mr-2"></i> Copies of your KCPE/KCSE Certificate or Results slip</li>
                                <li><i class="fas fa-check text-success me-2 mr-2"></i> Completed Medical Form KTVC/MED/1</li>
                            </ul>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>
                        @endif
                        <!-- Next Steps Section (Only visible to Approved students) -->
    
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header card-header-ktvc">
                    Quick Links
                </div>
                <div class="ul-group list-group list-group-flush">
                    <a href="{{ route('programmes') }}" class="list-group-item list-group-item-action"><i class="fas fa-book text-muted me-2"></i> Our Programmes</a>
                    <a href="{{ route('enquiry.page') }}" class="list-group-item list-group-item-action"><i class="fas fa-question-circle text-muted me-2"></i> Help & Support</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline m-0 p-0">
                        @csrf
                        <button type="submit" class="list-group-item list-group-item-action text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Profile Picture Upload Modal -->
    <div class="modal fade" id="profilePicModal" tabindex="-1" aria-labelledby="profilePicModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                
                <form action="{{ route('profile.picture.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="modal-header bg-light border-bottom-0">
                        <h5 class="modal-title fw-bold" id="profilePicModalLabel">
                            <i class="fas fa-image text-secondary"></i> Update Profile Picture
                        </h5>
                        <button type="button" class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body py-4 text-center">
                        <p class="text-muted mb-4">Please select a clear, passport-style photo. This will be used for your official KTVC Student ID.</p>
                        
                        <div class="form-group mb-0 text-start">
                            <input type="file" name="profile_picture" class="form-control p-1" accept=".jpg,.jpeg,.png" required>
                        </div>
                        @error('profile_picture')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="modal-footer bg-light border-top-0 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary fw-bold" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success fw-bold px-4">
                            <i class="fas fa-upload"></i> Upload Photo
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection