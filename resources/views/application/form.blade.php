@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0 mb-5">
                <div class="card-header card-header-ktvc text-center py-3">
                    <h4 class="mb-0">KTVC Online Admission Application</h4>
                </div>
                <div class="card-body p-4">
                    
                    <ul class="nav nav-pills nav-fill mb-4 border-bottom pb-3" id="applicationTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold" id="step1-tab" data-bs-target="#step1" type="button" role="tab" style="pointer-events: none;">1. Personal Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="step2-tab" data-bs-target="#step2" type="button" role="tab" style="pointer-events: none;">2. Course Selection</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="step3-tab" data-bs-target="#step3" type="button" role="tab" style="pointer-events: none;">3. Family & Guardians</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="step4-tab" data-bs-target="#step4" type="button" role="tab" style="pointer-events: none;">4. Location Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="step5-tab" data-bs-target="#step5" type="button" role="tab" style="pointer-events: none;">5. Documents & Submit</button>
                        </li>
                    </ul>
                    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

                    <form action="{{ route('application.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="tab-content" id="applicationTabsContent">
                            
                            <div class="tab-pane fade show active" id="step1" role="tabpanel">
                                <h5 class="mb-4" style="color: var(--ktvc-maroon);">Student Particulars</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">First Name (As on ID) *</label>
                                        <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $application->first_name ?? '') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name" value="{{ old('middle_name', $application->middle_name ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Surname *</label>
                                        <input type="text" class="form-control" name="surname" value="{{ old('surname', $application->surname ?? '') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                     <label class="form-label">National ID / Birth Cert No. *</label>
                                     <input type="text" class="form-control" name="id_number" value="{{ old('id_number', $application->id_number ?? '') }}" required>
                                 </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Gender *</label>
                                        <select class="form-select" name="gender" required>
                                        <option value="">Select...</option>
                                        <option value="Male" {{ old('gender', $application->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', $application->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Date of Birth *</label>
                                        <input type="date" class="form-control" name="dob" value="{{ old('dob', $application->dob ?? '') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Marital Status *</label>
                                        <select class="form-select" name="marital_status" required>
                                        <option value="">Select...</option>
                                        <option value="Single" {{ old('marital_status', $application->marital_status ?? '') == 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Married" {{ old('marital_status', $application->marital_status ?? '') == 'Married' ? 'selected' : '' }}>Married</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Mobile Number *</label>
                                        <input type="tel" 
                                               class="form-control" 
                                               name="phone_number" 
                                               value="{{ old('phone_number', $application->phone_number ?? '') }}" 
                                               pattern="[0-9]{10}" 
                                               maxlength="10" 
                                               title="Please enter exactly 10 digits (e.g., 0712345678)" 
                                               required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email Address (Verified)</label>
                                        <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-ktvc-primary next-tab">Next Step <i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="step2" role="tabpanel">
    <h5 class="mb-4" style="color: var(--ktvc-maroon);">Course Eligibility & Selection</h5>
    <div class="alert alert-info">
        Select your highest qualification grade. The system will automatically allocate your TVET level and show the courses you qualify for.
    </div>
    
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label fw-bold">Highest KCPE/KCSE Grade *</label>
            <select class="form-select" id="kcse_grade" name="kcse_grade" required>
                <option value="">Select Grade...</option>
                <option value="KCPE" {{ old('kcse_grade', $application->kcse_grade ?? '') == 'KCPE' ? 'selected' : '' }}>KCPE Certificate</option>
                <option disabled>──────────</option>
                @foreach(['E', 'D-', 'D', 'D+', 'C-', 'C', 'C+', 'B-', 'B', 'B+', 'A-', 'A'] as $grade)
                    <option value="{{ $grade }}" {{ old('kcse_grade', $application->kcse_grade ?? '') == $grade ? 'selected' : '' }}>KCSE Grade {{ $grade }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-4">
            <label class="form-label fw-bold">Allocated TVET Level</label>
            <input type="text" class="form-control bg-light" id="course_level_display" value="Level {{ old('course_level', $application->course_level ?? '--') }}" readonly>
            <input type="hidden" id="course_level" name="course_level" value="{{ old('course_level', $application->course_level ?? '') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label fw-bold">Select Programme *</label>
            <select class="form-select" id="course_name" name="course_name" required>
                <option value="">Select Grade First...</option>
                @if($application->course_name)
                    <option value="{{ $application->course_name }}" selected>{{ $application->course_name }}</option>
                @endif
            </select>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-secondary prev-tab"><i class="fas fa-arrow-left"></i> Previous</button>
        <button type="button" class="btn btn-ktvc-primary next-tab">Next Step <i class="fas fa-arrow-right"></i></button>
    </div>
</div>

                            <div class="tab-pane fade" id="step3" role="tabpanel">
                                <h5 class="mb-4" style="color: var(--ktvc-maroon);">Parents and Guardians' Details</h5>
                                
                                <div class="border p-3 mb-3 rounded bg-light">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input parent-alive-toggle" type="checkbox" id="father_alive" name="father_alive" value="1" {{ old('father_alive', $application->emergencyContacts->where('contact_type', 'father')->first()->is_alive ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="father_alive">Father is Alive</label>
                                    </div>
                                    <div class="row g-3" id="father_details_section">
                                        <div class="col-md-6">
                                            <label class="form-label">Father's Full Name</label>
                                            <input type="text" class="form-control" name="father_name" value="{{ old('father_name', $application->emergencyContacts->where('contact_type', 'father')->first()->full_name ?? '') }}">
                                        </div>
                                    <div class="col-md-6"> 
                                        <label class="form-label">Father's Phone Number *</label>
                                        <input type="tel" 
                                               class="form-control" 
                                               name="phone_number" 
                                               value="{{ old('father_phone', $application->emergencyContacts->where('contact_type', 'father')->first()->phone_number ?? '') }}" 
                                               pattern="[0-9]{10}" 
                                               maxlength="10" 
                                               title="Please enter exactly 10 digits (e.g., 0712345678)" 
                                               required>
                                        
                                    </div>
                                </div>

                                <div class="border p-3 mb-3 rounded bg-light">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input parent-alive-toggle" type="checkbox" id="mother_alive" name="mother_alive" value="1" {{ old('mother_alive', $application->emergencyContacts->where('contact_type', 'mother')->first()->is_alive ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="mother_alive">Mother is Alive</label>
                                    </div>
                                    <div class="row g-3" id="mother_details_section">
                                        <div class="col-md-6">
                                            <label class="form-label">Mother's Full Name</label>
                                            <input type="text" class="form-control" name="mother_name" value="{{ old('mother_name', $application->emergencyContacts->where('contact_type', 'mother')->first()->full_name ?? '') }}">
                                        </div>
                                        <div class="col-md-6"> 
                                        <label class="form-label">Mother's Phone Number *</label>
                                        <input type="tel" 
                                               class="form-control" 
                                               name="phone_number" 
                                               value="{{ old('mother_phone', $application->emergencyContacts->where('contact_type', 'mother')->first()->phone_number ?? '') }}" 
                                               pattern="[0-9]{10}" 
                                               maxlength="10" 
                                               title="Please enter exactly 10 digits (e.g., 0712345678)" 
                                               required>
                                        
                                    </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Guardian's Name (Emergency Contact) *</label>
                                        <input type="text" class="form-control" name="guardian_name" value="{{ old('guardian_name', $application->emergencyContacts->where('contact_type', 'guardian')->first()->full_name ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Guardian's Phone Number *</label>
                                        <input type="text" class="form-control" name="guardian_phone" value="{{ old('guardian_phone', $application->emergencyContacts->where('contact_type', 'guardian')->first()->phone_number ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Person Responsible for Fee Payment *</label>
                                        <input type="text" class="form-control" name="sponsor_name" value="{{ old('sponsor_name', $application->emergencyContacts->where('contact_type', 'fee_sponsor')->first()->full_name ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Fee Sponsor's Phone Number *</label>
                                        <input type="text" class="form-control" name="sponsor_phone" value="{{ old('sponsor_phone', $application->emergencyContacts->where('contact_type', 'fee_sponsor')->first()->phone_number ?? '') }}" required>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary prev-tab"><i class="fas fa-arrow-left"></i> Previous</button>
                                    <button type="button" class="btn btn-ktvc-primary next-tab">Next Step <i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="step4" role="tabpanel">
                                <h5 class="mb-4" style="color: var(--ktvc-maroon);">Location and Contact Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Home Address (P.O. Box) *</label>
                                        <input type="text" class="form-control" name="po_box" value="{{ old('po_box', $application->address->po_box ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Town/City *</label>
                                        <input type="text" class="form-control" name="town_city" value="{{ old('town_city', $application->address->town_city ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Home County *</label>
                                        <input type="text" class="form-control" name="county" value="{{ old('county', $application->address->home_county ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Sub-County *</label>
                                        <input type="text" class="form-control" name="sub_county" value="{{ old('sub_county', $application->address->sub_county ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Location *</label>
                                        <input type="text" class="form-control" name="location" value="{{ old('location', $application->address->location ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Sub-Location *</label>
                                        <input type="text" class="form-control" name="sub_location" value="{{ old('sub_location', $application->address->sub_location ?? '') }}" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Village *</label>
                                        <input type="text" class="form-control" name="village" value="{{ old('village', $application->address->village ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Chief’s Name *</label>
                                        <input type="text" class="form-control" name="chief_name" value="{{ old('chief_name', $application->address->chief_name ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Chief’s Phone Number *</label>
                                        <input type="text" class="form-control" name="chief_phone" value="{{ old('chief_phone', $application->address->chief_phone ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary prev-tab"><i class="fas fa-arrow-left"></i> Previous</button>
                                    <button type="button" class="btn btn-ktvc-primary next-tab">Next Step <i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="step5" role="tabpanel">
                                <h5 class="mb-4" style="color: var(--ktvc-maroon);">Academic & Identity Documents</h5>
                                <div class="alert alert-info">Please upload clear scanned copies (PDF or JPG, Max 2MB each).</div>
                                
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">KCPE Certificate / Result Slip *</label>
                                        <input type="file" class="form-control" name="kcpe_cert" accept=".pdf,.jpg,.jpeg,.png" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">KCSE Certificate / Result Slip *</label>
                                        <input type="file" class="form-control" name="kcse_cert" accept=".pdf,.jpg,.jpeg,.png" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Copy of National ID Card *</label>
                                        <input type="file" class="form-control" name="id_card" accept=".pdf,.jpg,.jpeg,.png" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Birth Certificate *</label>
                                        <input type="file" class="form-control" name="birth_cert" accept=".pdf,.jpg,.jpeg,.png" required>
                                    </div>
                                </div>

                                <hr>
                                
                                <h5 class="mb-3" style="color: var(--ktvc-maroon);">Data Protection and Media Consent</h5>
                                <div class="form-check mb-4 bg-light p-3 border rounded">
                                    <input class="form-check-input ms-1" type="checkbox" id="consent" name="consent_given" value="1" {{ old('consent_given', $application->consent_given ?? false) ? 'checked' : '' }} required>
                                    <label class="form-check-label ms-2 text-muted" for="consent" style="font-size: 0.9rem;">
                                        By accepting admission to Kipkabus Technical and Vocational College, I grant consent to the college to collect personal data for academic and administrative purposes. My photographs, audio, or video recordings taken during the training sessions, official functions, or any other college related activities may be used for sensitization purposes, including social media platforms, brochures, calendars, and official reports, while ensuring respect for privacy and dignity.
                                    </label>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary prev-tab"><i class="fas fa-arrow-left"></i> Previous</button>
                                    <button type="submit" id="submitBtn" class="btn btn-success fw-bold px-4 py-2"><i class="fas fa-paper-plane" disabled></i> Submit Application</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Wait for the entire webpage to load before running the script
    document.addEventListener('DOMContentLoaded', function() {
        
        // Grab the exact checkbox and button using their IDs
        const consentCheckbox = document.getElementById('consent');
        const submitButton = document.getElementById('submitBtn');

        // Listen for any 'change' (clicks) on the checkbox
        consentCheckbox.addEventListener('change', function() {
            
            // If the box is checked, remove the 'disabled' attribute. 
            // If it is unchecked, put the 'disabled' attribute back.
            submitButton.disabled = !this.checked;
            
        });
    });
</script>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        
        // Handle "Next" button clicks (Validate -> Auto-Save -> Move Tab)
        $('.next-tab').click(function(e) {
            e.preventDefault();
            let nextBtn = $(this);
            let currentTab = nextBtn.closest('.tab-pane');
            
            // 1. VALIDATION CHECK
            let isValid = true;
            let firstInvalidField = null;

            // Loop through only the required inputs/selects in the CURRENT tab
            currentTab.find('input[required], select[required]').each(function() {
                if (!this.checkValidity()) {
                    isValid = false;
                    if (!firstInvalidField) firstInvalidField = this;
                    
                    // Add Bootstrap's red border to the invalid field
                    $(this).addClass('is-invalid');
                } else {
                    // Remove the red border if they fixed it
                    $(this).removeClass('is-invalid');
                }
            });

            // If validation fails, stop everything and show the error
            if (!isValid) {
                // This triggers the browser's native "Please fill out this field" tooltip
                firstInvalidField.reportValidity();
                return false; 
            }

            // 2. IF VALID, PROCEED WITH AUTOSAVE
            let originalText = nextBtn.html();
            nextBtn.html('<i class="fas fa-spinner fa-spin"></i> Saving...');
            
            let formData = $('form').serialize();

            $.ajax({
                url: "{{ route('application.autosave') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    nextBtn.html(originalText);
                    
                    // Move to the next tab ONLY after saving successfully
                    const nextTabLinkEl = $('.nav-pills .active').parent().next('li').find('button');
                    const nextTab = new bootstrap.Tab(nextTabLinkEl);
                    nextTab.show();
                },
                error: function() {
                    alert("Network error: Could not save progress. Please check your connection.");
                    nextBtn.html(originalText);
                }
            });
        });

        // Handle "Previous" button clicks (Just move tab, no need to save)
        $('.prev-tab').click(function() {
            const prevTabLinkEl = $('.nav-pills .active').parent().prev('li').find('button');
            const prevTab = new bootstrap.Tab(prevTabLinkEl);
            prevTab.show();
        });

        // Fetch courses when Grade changes
$('#kcse_grade').change(function() {
    let grade = $(this).val();
    let courseSelect = $('#course_name');
    let levelDisplay = $('#course_level_display');
    let levelHidden = $('#course_level');

    if(grade) {
        courseSelect.html('<option value="">Loading courses...</option>');
        
        $.ajax({
            url: "{{ route('application.courses') }}",
            type: "GET",
            data: { grade: grade },
            success: function(response) {
                if(response.success) {
                    // Update Level
                    levelDisplay.val('Level ' + response.level);
                    levelHidden.val(response.level);
                    
                    // Populate Courses
                    courseSelect.empty();
                    courseSelect.append('<option value="">Select a Course...</option>');
                    $.each(response.courses, function(index, course) {
                        courseSelect.append('<option value="'+ course +'">'+ course +'</option>');
                    });
                }
            }
        });
    } else {
        courseSelect.html('<option value="">Select Grade First...</option>');
        levelDisplay.val('Level --');
        levelHidden.val('');
    }
});

// If the page loads with a grade already selected (from auto-save draft), trigger the fetch automatically
if ($('#kcse_grade').val()) {
    // Keep the currently selected course in a variable so it doesn't get wiped
    let currentCourse = "{{ $application->course_name ?? '' }}";
    
    $.ajax({
        url: "{{ route('application.courses') }}",
        type: "GET",
        data: { grade: $('#kcse_grade').val() },
        success: function(response) {
            if(response.success) {
                let courseSelect = $('#course_name');
                courseSelect.empty();
                courseSelect.append('<option value="">Select a Course...</option>');
                $.each(response.courses, function(index, course) {
                    let selected = (course === currentCourse) ? 'selected' : '';
                    courseSelect.append('<option value="'+ course +'" '+ selected +'>'+ course +'</option>');
                });
            }
        }
    });
}

        // Handle Parent Alive/Deceased Checkbox Toggle
        $('.parent-alive-toggle').change(function() {
            const isAlive = $(this).is(':checked');
            const targetSection = $(this).attr('id') === 'father_alive' ? '#father_details_section' : '#mother_details_section';
            
            if (isAlive) {
                $(targetSection).slideDown();
                // We remove the strict 'required' attribute here so autosave works smoothly
                // Validation will catch it on final submission anyway!
            } else {
                $(targetSection).slideUp();
                $(targetSection).find('input').val('');
            }
        });
        
        $('.parent-alive-toggle').trigger('change');
    });
</script>
@endpush