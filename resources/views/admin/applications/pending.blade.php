@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary" style="border-top-color: #7B1818;">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Registrar Queue</h3>
                <div class="card-tools">
                    <span class="badge badge-warning">{{ $applications->count() }} Pending Review</span>
                </div>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead>
                            <tr>
                                <th class="px-4">#</th>
                                <th>Applicant Name</th>
                                <th>Email / ID</th>
                                <th>Gender</th>
                                <th>Date Submitted</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $index => $app)
                                <tr>
                                    <td class="px-4 font-weight-bold">{{ $index + 1 }}</td>
                                    <td>{{ strtoupper($app->first_name . ' ' . $app->surname) }}</td>
                                    <td>{{ $app->user->email ?? $app->user->index_number }}</td>
                                    <td>{{ $app->gender }}</td>
                                    <td>{{ $app->updated_at->format('d M Y, H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.applications.show', $app->id) }}" class="btn btn-sm btn-primary" style="background-color: #7B1818; border: none;">
                                            <i class="fas fa-search"></i> Review Docs
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-check-double fa-3x mb-3 text-success"></i>
                                        <h5>All Caught Up!</h5>
                                        <p>There are no pending applications waiting for your approval.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection