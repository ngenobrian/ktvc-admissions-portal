@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.applications.pending') }}" class="btn btn-secondary btn-sm mb-2 shadow-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <h3 style="color: var(--ktvc-maroon); margin-bottom: 0;">
                Review Application: {{ strtoupper($application->first_name . ' ' . $application->surname) }}
            </h3>
        </div>
        
        <div>
            @if($application->status === 'approved')
                <span class="badge bg-success fs-5 px-3 py-2 shadow-sm"><i class="fas fa-check-circle"></i> APPROVED</span>
            @elseif($application->status === 'rejected')
                <span class="badge bg-danger fs-5 px-3 py-2 shadow-sm"><i class="fas fa-times-circle"></i> REJECTED</span>
            @else
                <span class="badge bg-warning text-dark fs-5 px-3 py-2 shadow-sm"><i class="fas fa-hourglass-half"></i> PENDING</span>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            
            <div class="card shadow-sm border-0 mb-4" style="border-top: 4px solid var(--ktvc-maroon) !important;">
                <div class="card-header bg-white pb-0 border-bottom-0 pt-3">
                    <h5 class="fw-bold"><i class="fas fa-graduation-cap text-secondary"></i> Course Selection</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">Course Applied For</label>
                            <p class="fs-5 mb-0 fw-bold">{{ $application->course_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">Course Level</label>
                            <p class="fs-5 mb-0"><span class="badge bg-secondary">Level {{ $application->course_level ?? 'N/A' }}</span></p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">KCSE/KCPE Grade</label>
                            <p class="fs-5 mb-0"><span class="badge bg-info text-dark border border-info">{{ $application->kcse_grade ?? 'N/A' }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white pb-0 border-bottom-0 pt-3">
                    <h5 class="fw-bold"><i class="fas fa-user text-secondary"></i> Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">First Name</label>
                            <p class="mb-0 fw-bold">{{ $application->first_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">Middle Name</label>
                            <p class="mb-0 fw-bold">{{ $application->middle_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">Surname</label>
                            <p class="mb-0 fw-bold">{{ $application->surname ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                         <label class="text-muted small fw-bold mb-1">National ID / Birth Cert</label>
                         <p class="mb-0 fw-bold">{{ $application->id_number ?? 'N/A' }}</p>
                     </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">Gender</label>
                            <p class="mb-0">{{ strtoupper($application->gender ?? 'N/A') }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">Index / ID Number</label>
                            <p class="mb-0">{{ $application->user->index_number ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">Date of Birth</label>
                            <p class="mb-0">{{ $application->dob ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white pb-0 border-bottom-0 pt-3">
                    <h5 class="fw-bold"><i class="fas fa-address-book text-secondary"></i> Contact Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small fw-bold mb-1">Phone Number</label>
                            <p class="mb-0">{{ $application->phone_number ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small fw-bold mb-1">Email Address</label>
                            <p class="mb-0">{{ $application->user->email ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small fw-bold mb-1">Postal Address</label>
                            <p class="mb-0">{{ $application->town_city ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small fw-bold mb-1">Next of Kin Contact</label>
                            <p class="mb-0">{{ $application->next_of_kin_phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white pb-0 border-bottom-0 pt-3">
                    <h5 class="fw-bold"><i class="fas fa-map-marker-alt text-secondary"></i> Location Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">P.O. Box</label>
                            <p class="mb-0">{{ $application->address->po_box ?? 'N/A' }} - {{ $application->address->town_city ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">County</label>
                            <p class="mb-0">{{ $application->address->home_county ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">Sub-County</label>
                            <p class="mb-0">{{ $application->address->sub_county ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">Location / Ward</label>
                            <p class="mb-0">{{ $application->address->location ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">Sub-Location</label>
                            <p class="mb-0">{{ $application->address->sub_location ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small fw-bold mb-1">Village</label>
                            <p class="mb-0">{{ $application->address->village ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small fw-bold mb-1">Chief's Name</label>
                            <p class="mb-0">{{ $application->address->chief_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small fw-bold mb-1">Chief's Phone</label>
                            <p class="mb-0">{{ $application->address->chief_phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white pb-0 border-bottom-0 pt-3">
                    <h5 class="fw-bold"><i class="fas fa-users text-secondary"></i> Family & Guardians</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php 
                            $father = $application->emergencyContacts->where('contact_type', 'father')->first();
                            $mother = $application->emergencyContacts->where('contact_type', 'mother')->first();
                            $guardian = $application->emergencyContacts->where('contact_type', 'guardian')->first();
                            $sponsor = $application->emergencyContacts->where('contact_type', 'fee_sponsor')->first();
                        @endphp
                        
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small fw-bold mb-1">Father's Details</label>
                            @if($father && $father->is_alive)
                                <p class="mb-0 fw-bold">{{ strtoupper($father->full_name) }}</p>
                                <p class="mb-0 small text-muted"><i class="fas fa-phone-alt"></i> {{ $father->phone_number ?? 'No Phone' }}</p>
                            @else
                                <p class="mb-0 text-danger fw-bold">DECEASED / N/A</p>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-muted small fw-bold mb-1">Mother's Details</label>
                            @if($mother && $mother->is_alive)
                                <p class="mb-0 fw-bold">{{ strtoupper($mother->full_name) }}</p>
                                <p class="mb-0 small text-muted"><i class="fas fa-phone-alt"></i> {{ $mother->phone_number ?? 'No Phone' }}</p>
                            @else
                                <p class="mb-0 text-danger fw-bold">DECEASED / N/A</p>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-muted small fw-bold mb-1">Guardian (Emergency Contact)</label>
                            <p class="mb-0 fw-bold">{{ strtoupper($guardian->full_name ?? 'N/A') }}</p>
                            <p class="mb-0 small text-muted"><i class="fas fa-phone-alt"></i> {{ $guardian->phone_number ?? 'N/A' }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-muted small fw-bold mb-1">Fee Sponsor</label>
                            <p class="mb-0 fw-bold">{{ strtoupper($sponsor->full_name ?? 'N/A') }}</p>
                            <p class="mb-0 small text-muted"><i class="fas fa-phone-alt"></i> {{ $sponsor->phone_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-left: 4px solid #17a2b8 !important;">
                <div class="card-header bg-white pb-0 border-bottom-0 pt-3">
                    <h5 class="fw-bold"><i class="fas fa-file-pdf text-info"></i> Uploaded Documents</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-4">Click on any document below to securely view or download it in a new tab for verification.</p>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-dark fw-bold mb-2">National ID / Passport</label>
                            @php $idDoc = $application->documents->where('document_type', 'national_id')->first(); @endphp
                            @if($idDoc) 
                                <a href="{{ asset('storage/' . $idDoc->file_path) }}" target="_blank" class="btn btn-outline-info w-100 d-flex justify-content-between align-items-center shadow-sm">
                                    <span><i class="fas fa-id-card me-2"></i> View ID Document</span>
                                    <i class="fas fa-external-link-alt small"></i>
                                </a>
                            @else
                                <div class="alert alert-light text-danger border border-danger mb-0 py-2 text-center">
                                    <i class="fas fa-times-circle"></i> Not Uploaded
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-dark fw-bold mb-2">KCSE Result Slip / Cert</label>
                            @php $kcseDoc = $application->documents->where('document_type', 'kcse')->first(); @endphp
                            @if($kcseDoc) 
                                <a href="{{ asset('storage/' . $kcseDoc->file_path) }}" target="_blank" class="btn btn-outline-info w-100 d-flex justify-content-between align-items-center shadow-sm">
                                    <span><i class="fas fa-certificate me-2"></i> View KCSE</span>
                                    <i class="fas fa-external-link-alt small"></i>
                                </a>
                            @else
                                <div class="alert alert-light text-danger border border-danger mb-0 py-2 text-center">
                                    <i class="fas fa-times-circle"></i> Not Uploaded
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="text-dark fw-bold mb-2">KCPE Result Slip / Cert</label>
                            @php $kcpeDoc = $application->documents->where('document_type', 'kcpe')->first(); @endphp
                            @if($kcpeDoc) 
                                <a href="{{ asset('storage/' . $kcpeDoc->file_path) }}" target="_blank" class="btn btn-outline-info w-100 d-flex justify-content-between align-items-center shadow-sm">
                                    <span><i class="fas fa-certificate me-2"></i> View KCPE</span>
                                    <i class="fas fa-external-link-alt small"></i>
                                </a>
                            @else
                                <div class="alert alert-light text-danger border border-danger mb-0 py-2 text-center">
                                    <i class="fas fa-times-circle"></i> Not Uploaded
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-dark fw-bold mb-2">Birth Certificate</label>
                            @php $birthDoc = $application->documents->where('document_type', 'birth_cert')->first(); @endphp
                            @if($birthDoc) 
                                <a href="{{ asset('storage/' . $birthDoc->file_path) }}" target="_blank" class="btn btn-outline-info w-100 d-flex justify-content-between align-items-center shadow-sm">
                                    <span><i class="fas fa-child me-2"></i> View Birth Cert</span>
                                    <i class="fas fa-external-link-alt small"></i>
                                </a>
                            @else
                                <div class="alert alert-light text-danger border border-danger mb-0 py-2 text-center">
                                    <i class="fas fa-times-circle"></i> Not Uploaded
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="text-dark fw-bold mb-2">Passport Photo</label>
                            @if($application->user && $application->user->profile_picture) 
                                <a href="{{ asset('storage/' . $application->user->profile_picture) }}" target="_blank" class="btn btn-outline-info w-100 d-flex justify-content-between align-items-center shadow-sm">
                                    <span><i class="fas fa-camera me-2"></i> View Photo</span>
                                    <i class="fas fa-external-link-alt small"></i>
                                </a>
                            @else
                                <div class="alert alert-light text-danger border border-danger mb-0 py-2 text-center">
                                    <i class="fas fa-times-circle"></i> Not Uploaded
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        <div class="col-lg-4">
            <div class="card shadow border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-dark text-white pt-3 pb-2">
                    <h5 class="fw-bold mb-0"><i class="fas fa-gavel"></i> Registrar Decision</h5>
                </div>
                <div class="card-body bg-light">
                    <p class="text-muted small mb-4">Review the applicant's details carefully. Approving this application will allow the student to download their official KTVC Admission Letter.</p>

                    <form action="{{ route('admin.applications.status', $application->id) }}" method="POST">
                        @csrf
                        
                        <button type="submit" name="status" value="approved" class="btn btn-success fw-bold w-100 py-3 mb-3 shadow-sm d-flex justify-content-center align-items-center" {{ $application->status === 'approved' ? 'disabled' : '' }}>
                            <i class="fas fa-check-circle fs-4 me-2 mr-2"></i> Approve Application
                        </button>

                        <button type="submit" name="status" value="pending" class="btn btn-warning fw-bold w-100 py-2 mb-3 shadow-sm" {{ $application->status === 'pending' ? 'disabled' : '' }}>
                            <i class="fas fa-undo"></i> Revert to Pending
                        </button>

                        <button type="button" 
                                id="denyBtnTrigger"
                                class="btn btn-outline-danger fw-bold w-100 py-2" 
                                {{ $application->status === 'rejected' ? 'disabled' : '' }} 
                                data-toggle="modal" data-target="#rejectModal" 
                                data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fas fa-times"></i> Deny Application
                        </button>

                    </form>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    <small class="text-muted">Application submitted on:<br><strong>{{ $application->created_at->format('l, d F Y \a\t h:i A') }}</strong></small>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <form action="{{ route('admin.applications.status', $application->id) }}" method="POST">
                 @csrf
                 <input type="hidden" name="status" value="rejected">

                 <div class="modal-header bg-danger text-white">
                     <h5 class="modal-title" id="rejectModalLabel"><i class="fas fa-exclamation-triangle"></i> Reject Application</h5>
                     <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>

                 <div class="modal-body">
                     <p>You are about to reject the application for <strong>{{ strtoupper($application->first_name . ' ' . $application->surname) }}</strong>.</p>

                     <div class="mb-3">
                         <label for="rejection_reason" class="form-label fw-bold">Reason for Rejection *</label>
                         <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" placeholder="e.g., The KCSE result slip uploaded is blurry. Please upload a clear scanned copy." required></textarea>
                         <div class="form-text text-muted">This reason will be emailed directly to the applicant so they can make amendments.</div>
                     </div>
                 </div>

                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-danger fw-bold"><i class="fas fa-times-circle"></i> Confirm Rejection</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if jQuery is loaded (common in Admin dashboards)
            if (window.jQuery) {
                $('#denyBtnTrigger').on('click', function(e) {
                    e.preventDefault();
                    $('#rejectModal').modal('show');
                });
            }
        });
    </script>
 
@endsection