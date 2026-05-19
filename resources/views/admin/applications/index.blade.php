@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 style="color: var(--ktvc-maroon);"><i class="fas fa-folder-open"></i> Manage Applications</h3>
        
        <div class="btn-group shadow-sm">
            <a href="{{ route('admin.applications.pending', ['status' => 'pending']) }}" class="btn {{ $status === 'pending' ? 'btn-warning text-dark fw-bold' : 'btn-light' }}">Pending</a>
            <a href="{{ route('admin.applications.pending', ['status' => 'approved']) }}" class="btn {{ $status === 'approved' ? 'btn-success fw-bold' : 'btn-light' }}">Approved</a>
            <a href="{{ route('admin.applications.pending', ['status' => 'rejected']) }}" class="btn {{ $status === 'rejected' ? 'btn-danger fw-bold' : 'btn-light' }}">Rejected</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Admission No / ID</th>
                            <th>Applicant Name</th>
                            <th>Course</th>
                            <th>Date Applied</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $app)
                            <tr>
                                <td><strong>{{ $app->admission_number ?? 'N/A' }}</strong></td>
                                <td>
                                    {{ strtoupper($app->first_name . ' ' . $app->surname) }}<br>
                                    <small class="text-muted">{{ $app->phone_number }}</small>
                                </td>
                                <td>{{ $app->course_name }} <br><span class="badge bg-secondary">{{ $app->course_level }}</span></td>
                                <td>{{ $app->created_at->format('d M Y') }}</td>
                                <td>
                                    @if($app->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($app->status === 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.applications.show', $app->id) }}" class="btn btn-sm btn-primary shadow-sm">
                                        <i class="fas fa-eye"></i> Review
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fs-1 mb-3 text-light"></i><br>
                                    No {{ $status }} applications found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($applications->hasPages())
            <div class="card-footer bg-white border-top-0 pt-3">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection