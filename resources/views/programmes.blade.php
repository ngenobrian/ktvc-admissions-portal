@extends('layouts.app') <!-- Change this to your main public layout name -->

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: var(--ktvc-maroon);">Our Programmes</h1>
        <p class="lead text-muted">Kipkabus Technical and Vocational College</p>
        <p>Short courses offered: Driving Course, Computer Packages, Cake Baking. Application for Recognition of Prior Learning (RPL) is open.</p>
    </div>

    <!-- Department 1: Building and Civil Engineering -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Department of Building and Civil Engineering</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Course</th>
                            <th>Minimum Entry Requirements</th>
                            <th>Duration</th>
                            <th>Intake Period</th>
                            <th>Exam Body</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Civil Engineering Level 6 </td>
                            <td>KCSE C- (MINUS) & Above </td>
                            <td>7 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <!-- The Dynamic Apply Button -->
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Building Construction Technology Level 6 </td>
                            <td>KCSE C- (MINUS) & Above </td>
                            <td>7 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Land Surveying Level 6 </td>
                            <td>KCSE C- (MINUS) & Above </td>
                            <td>7 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Quantity Surveying Level 6 </td>
                            <td>KCSE C- (MINUS) & Above </td>
                            <td>7 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Water Engineering Level 6 </td>
                            <td>KCSE C- (MINUS) & Above </td>
                            <td>7 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Architectural Technology Level 6 </td>
                            <td>KCSE C- (MINUS) & Above </td>
                            <td>7 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Building Technology Level 5 </td>
                            <td>KCSE D (PLAIN) & D+ (PLUS) </td>
                            <td>4 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Land Surveying Level 5 </td>
                            <td>KCSE D (PLAIN) & D+ (PLUS) </td>
                            <td>4 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Plumbing Level 5 </td>
                            <td>KCSE D (PLAIN) & D+ (PLUS) </td>
                            <td>4 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Plumbing Level 4 </td>
                            <td>KCSE D- (MINUS) & E </td>
                            <td>2 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Masonry Level 4 </td>
                            <td>KCSE D- (MINUS) & E </td>
                            <td>2 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Plumbing Level 3 </td>
                            <td>KCPE </td>
                            <td>1 Module </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Masonry Level 3 </td>
                            <td>KCPE </td>
                            <td>1 Module </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Department 2: Mechanical and Automotive Engineering -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Department of Mechanical and Automotive Engineering </h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Course</th>
                            <th>Minimum Entry Requirements</th>
                            <th>Duration</th>
                            <th>Intake Period</th>
                            <th>Exam Body</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mechanical Plant Engineering Technology Level 6 </td>
                            <td>KCSE C- (MINUS) & Above </td>
                            <td>7 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Mechanical Technology (Production) Level 6 </td>
                            <td>KCSE C- (MINUS) & Above </td>
                            <td>7 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Automotive Engineering Level 6 </td>
                            <td>KCSE C- (MINUS) & Above </td>
                            <td>7 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Agriculture Extension Level 6 </td>
                            <td>KCSE C- (MINUS) & Above </td>
                            <td>7 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Science Laboratory Technology Level 6 </td>
                            <td>KCSE C- (MINUS) & Above </td>
                            <td>7 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Mechanical Production Technology Level 5 </td>
                            <td>KCSE D (PLAIN) & D+ (PLUS) </td>
                            <td>4 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Automotive Engineering Level 5 </td>
                            <td>KCSE D (PLAIN) & D+ (PLUS) </td>
                            <td>4 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Welding and Fabrication Level 5 </td>
                            <td>KCSE D (PLAIN) & D+ (PLUS) </td>
                            <td>4 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Agriculture Extension Level 5 </td>
                            <td>KCSE D (PLAIN) & D+ (PLUS) </td>
                            <td>4 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Science Laboratory Technology Level 5 </td>
                            <td>KCSE D (PLAIN) & D+ (PLUS) </td>
                            <td>4 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>CNC Lathe Operation Level 4 </td>
                            <td>KCSE D- (MINUS) & E </td>
                            <td>2 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>General Agriculture Level 4 </td>
                            <td>KCSE D- (MINUS) & E </td>
                            <td>2 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Automotive Technology Level 4 </td>
                            <td>KCSE D- (MINUS) & E </td>
                            <td>2 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        <tr>
                            <td>Welding Level 4 </td>
                            <td>KCSE D- (MINUS) & E </td>
                            <td>2 Modules </td>
                            <td>JAN/MAY/SEPT </td>
                            <td>CDACC </td>
                            <td><a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-sm btn-success fw-bold px-3">Apply</a></td>
                        </tr>
                        
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modular Training Info Box -->
    <div class="alert alert-info shadow-sm mt-4">
        <h5 class="fw-bold"><i class="fas fa-info-circle"></i> Modular Training Structure </h5>
        <p class="mb-2">All courses are divided into modules, each Module takes 1 term (3 months) .</p>
        <ul class="mb-0">
            <li><strong>LEVEL 6:</strong> 7 Modules + Industrial Attachment </li>
            <li><strong>LEVEL 5:</strong> 4 Modules + Industrial Attachment </li>
            <li><strong>LEVEL 4:</strong> 2 Modules + Industrial Attachment </li>
            <li><strong>LEVEL 3:</strong> 1 Module + Industrial Attachment </li>
        </ul>
    </div>

</div>
@endsection