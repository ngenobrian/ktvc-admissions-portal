<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApprovedStudentsExport;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationReviewed;
use App\Models\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // 1. Admin Analytics Dashboard
    public function dashboard()
    {
        $statusCounts = Application::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $pendingApplications = ($statusCounts['pending'] ?? 0) + ($statusCounts['submitted'] ?? 0);
        $approvedApplications = $statusCounts['approved'] ?? 0;
        $rejectedApplications = $statusCounts['rejected'] ?? 0;

        $totalApplications = $pendingApplications + $approvedApplications + $rejectedApplications;

        $coursesData = Application::select('course_name', DB::raw('count(*) as total'))
            ->where('status', 'approved')
            ->groupBy('course_name')
            ->pluck('total', 'course_name');

        $genderData = Application::select('gender', DB::raw('count(*) as total'))
            ->where('status', 'approved')
            ->groupBy('gender')
            ->pluck('total', 'gender');

        return view('admin.dashboard', compact(
            'totalApplications', 'pendingApplications', 'approvedApplications', 'rejectedApplications',
            'coursesData', 'genderData'
        ));
    }

    // 2. List all applications (Handles pending, approved, rejected via URL ?status= filter)
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending'); 

        // Included fallback for 'submitted' just in case old records exist
        $applications = Application::with('user')
            ->whereIn('status', [$status, $status === 'pending' ? 'submitted' : $status])
            ->latest()
            ->paginate(15);

        return view('admin.applications.index', compact('applications', 'status'));
    }

    // 3. View a single application in detail
    public function show($id)
    {
        $application = Application::with(['user', 'address', 'emergencyContacts', 'documents'])->findOrFail($id);
        
        return view('admin.applications.show', compact('application'));
    }

    // 4. Update the status and send emails
    public function updateStatus(Request $request, $id)
    {
        $application = \App\Models\Application::findOrFail($id);
        
        // 1. Validate the input (Ensure reason is provided IF rejected)
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string'
        ]);

        // 2. Update the status
        $application->status = $request->status;
        
        // 3. Handle the rejection reason
        if ($request->status === 'rejected') {
            $application->rejection_reason = $request->rejection_reason;
        } else {
            // Clear the reason if the application is approved or reverted to pending
            $application->rejection_reason = null; 
        }
        
        $application->save();

        // 4. Send Email Notification to the Trainee
        if (in_array($request->status, ['approved', 'rejected'])) {
            \Illuminate\Support\Facades\Mail::to($application->user->email)
                ->send(new \App\Mail\ApplicationReviewed($application));
        }

        return back()->with('success', 'Application status updated to ' . strtoupper($request->status) . ' successfully.');
    }

    // 5. Export Approved Students to Excel
    public function exportApprovedStudents()
    {
        return Excel::download(new ApprovedStudentsExport, 'KTVC_Approved_Students_' . date('Y_m_d') . '.xlsx');
    }

    
}