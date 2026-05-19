@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h2 style="color: var(--ktvc-maroon);"><i class="fas fa-inbox"></i> Student Enquiries</h2>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Student Details</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enquiries as $enquiry)
                            <tr>
                                <td>{{ $enquiry->created_at->format('d M Y, h:i A') }}</td>
                                <td>
                                    <strong>{{ $enquiry->name }}</strong><br>
                                    <small class="text-muted">{{ $enquiry->email }} | {{ $enquiry->phone_number }}</small>
                                </td>
                                <td style="max-width: 300px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                    {{ $enquiry->message }}
                                </td>
                                <td>
                                    @if($enquiry->status === 'resolved')
                                        <span class="badge bg-success">Resolved</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#replyModal{{ $enquiry->id }}">
                                        {{ $enquiry->status === 'resolved' ? 'View Reply' : 'Reply' }}
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="replyModal{{ $enquiry->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title fw-bold">Reply to {{ $enquiry->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.enquiries.reply', $enquiry->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="p-3 bg-light rounded mb-4 border-start border-4 border-secondary">
                                                    <strong>Student Asked:</strong><br>
                                                    <p class="mb-0 mt-2" style="white-space: pre-wrap;">{{ $enquiry->message }}</p>
                                                </div>

                                                <label class="form-label fw-bold">Your Response:</label>
                                                @if($enquiry->status === 'resolved')
                                                    <div class="p-3 border rounded bg-white">
                                                        <p class="mb-0" style="white-space: pre-wrap;">{{ $enquiry->admin_response }}</p>
                                                    </div>
                                                @else
                                                    <textarea name="admin_response" class="form-control" rows="5" placeholder="Type your reply here. This will be sent directly to their email..." required></textarea>
                                                @endif
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                @if($enquiry->status === 'pending')
                                                    <button type="submit" class="btn btn-success fw-bold"><i class="fas fa-paper-plane"></i> Send Reply Email</button>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No enquiries found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $enquiries->links() }}</div>
    </div>
</div>
@endsection