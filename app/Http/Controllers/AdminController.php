<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApprovedStudentsExport;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationReviewed;

use App\Models\Application;

class AdminController extends Controller
{
    // Admin Analytics Dashboard
    public function dashboard()
    {
        // 1. Top Level Metrics
        $totalApplications = \App\Models\Application::count();
        $pendingApplications = \App\Models\Application::where('status', 'pending')->count();
        $approvedApplications = \App\Models\Application::where('status', 'approved')->count();
        $rejectedApplications = \App\Models\Application::where('status', 'rejected')->count();

        // 2. Chart Data: Applications by Course
        $coursesData = \App\Models\Application::select('course_name', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('course_name')
            ->pluck('total', 'course_name');

        // 3. Chart Data: Gender Distribution
        $genderData = \App\Models\Application::select('gender', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender');

        return view('admin.dashboard', compact(
            'totalApplications', 'pendingApplications', 'approvedApplications', 'rejectedApplications',
            'coursesData', 'genderData'
        ));
    }
    // Show the list of pending applications for the Registrar
    public function pendingApplications()
    {
        // Fetch applications that are submitted, along with their associated user data
        $applications = Application::with('user')
            ->where('status', 'submitted')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.applications.pending', compact('applications'));
    }

    // View a single application in detail
    public function showApplication($id)
    {
        $application = Application::with(['user', 'address', 'emergencyContacts', 'documents'])->findOrFail($id);
        
        return view('admin.applications.show', compact('application'));
    }

    
    /* public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            // Rejection reason is ONLY required if the status is 'rejected'
            'rejection_reason' => 'required_if:status,rejected|string|max:1000|nullable', 
        ]);

        $application = Application::findOrFail($id);
        
        $application->status = $request->status;
        
        if ($request->status == 'rejected') {
            $application->rejection_reason = $request->rejection_reason;
            // Optional: You can trigger a Mail notification here to alert the trainee
        } else {
            // If approved, clear any previous rejection reasons
            $application->rejection_reason = null; 
            
            // Optional: Generate Admission Number and Letter here (like we discussed earlier)
        }

        $application->save();

        // Save the changes to the database first
        $application->save();

        // Send the Email Notification (Check if the user actually has an email address first)
        if ($application->user && $application->user->email) {
            try {
                Mail::to($application->user->email)->send(new ApplicationReviewed($application));
            } catch (\Exception $e) {
                // If the email fails (e.g., bad SMTP settings), don't break the whole app. 
                // Just log the error or flash a warning to the admin.
                \Log::error('Mail failed to send: ' . $e->getMessage());
                return redirect()->route('admin.applications.pending')
                    ->with('success', 'Application status updated, but the email notification failed to send.');
            }
        }

        // Return back to the dashboard with the success message
        $message = $request->status == 'approved' ? 'Application Approved Successfully!' : 'Application Rejected. The trainee has been notified.';
        return redirect()->route('admin.applications.pending')->with('success', $message);
    } */

    // Export Approved Students to Excel
    public function exportApprovedStudents()
    {
        return Excel::download(new ApprovedStudentsExport, 'KTVC_Approved_Students_' . date('Y_m_d') . '.xlsx');
    }

    // 1. List all applications
    public function index(Request $request)
    {
        // Default to showing 'pending' applications, but allow filtering via URL
        $status = $request->query('status', 'pending'); 

        $applications = \App\Models\Application::with('user')
            ->where('status', $status)
            ->latest()
            ->paginate(15);

        return view('admin.applications.index', compact('applications', 'status'));
    }

    // 2. View a single application in detail
    public function show($id)
    {
        $application = \App\Models\Application::with('user')->findOrFail($id);
        
        return view('admin.applications.show', compact('application'));
    }

    // 3. Update the status (Approve or Reject)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $application = \App\Models\Application::findOrFail($id);
        $application->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Application status updated to ' . ucfirst($request->status) . ' successfully!');
    }
}
