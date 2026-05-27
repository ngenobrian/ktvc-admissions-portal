@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 style="color: var(--ktvc-maroon); margin-bottom: 0;"><i class="fas fa-chart-line"></i> Admissions Overview</h2>
            <p class="text-muted mb-0">Real-time statistics for the upcoming intake.</p>
        </div>
        
        <div>
            <a href="{{ route('admin.export.approved') }}" class="btn btn-success fw-bold shadow-sm">
                <i class="fas fa-file-excel"></i> Export Approved to Excel
            </a>
        </div>
    </div>
<div class="container-fluid py-4">
    <!-- <div class="mb-4">
        <h2 style="color: var(--ktvc-maroon);"><i class="fas fa-chart-line"></i> Admissions Overview</h2>
        <p class="text-muted">Real-time statistics for the upcoming intake.</p>
    </div> -->

    <!-- TOP ROW: Stat Boxes -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info shadow-sm border-0 rounded">
                <div class="inner">
                    <h3>{{ $totalApplications }}</h3>
                    <p>Total Applications</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning shadow-sm border-0 rounded">
                <div class="inner">
                    <h3>{{ $pendingApplications }}</h3>
                    <p>Pending Review</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success shadow-sm border-0 rounded">
                <div class="inner">
                    <h3>{{ $approvedApplications }}</h3>
                    <p>Approved Admissions</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger shadow-sm border-0 rounded">
                <div class="inner">
                    <h3>{{ $rejectedApplications }}</h3>
                    <p>Returned / Rejected</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- SECOND ROW: Charts -->
    <div class="row mt-4">
        <!-- Bar Chart: Courses -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold"><i class="fas fa-book-reader"></i> Approved applications by Course</h5>
                </div>
                <div class="card-body">
                    <canvas id="courseChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Pie Chart: Gender -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold"><i class="fas fa-venus-mars"></i> Gender Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="genderChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. Course Bar Chart ---
    const courseCtx = document.getElementById('courseChart').getContext('2d');
    const courseData = @json($coursesData);
    
    new Chart(courseCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(courseData),
            datasets: [{
                label: 'Number of Applicants',
                data: Object.values(courseData),
                backgroundColor: '#7B1818', // KTVC Maroon
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            },
            plugins: { legend: { display: false } }
        }
    });

    // --- 2. Gender Pie Chart ---
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    const genderData = @json($genderData);

    new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(genderData).map(key => key.charAt(0).toUpperCase() + key.slice(1)), // Capitalize
            datasets: [{
                data: Object.values(genderData),
                backgroundColor: ['#17a2b8', '#e83e8c', '#6c757d'], // Blue, Pink, Grey
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutout: '60%',
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});
</script>
@endsection