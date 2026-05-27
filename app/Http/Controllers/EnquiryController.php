<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnquiryReply;

class EnquiryController extends Controller
{
    // Show the public Enquiry Page
    public function create()
    {
        return view('enquiry');
    }
    // 1. TRAINEE: Submit the Enquiry
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        Enquiry::create($request->all());

        return back()->with('success', 'Your enquiry has been sent successfully. We will reply to your email shortly.');
    }

    public function index(Request $request)
    {
        // Check the URL for the 'tab' parameter. Default to 'active' if none exists.
        $tab = $request->query('tab', 'active');
        
        // Determine the database status based on the tab
        $status = $tab === 'archived' ? 'resolved' : 'pending';

        // Fetch the filtered enquiries
        $enquiries = \App\Models\Enquiry::where('status', $status)
            ->latest()
            ->paginate(15)
            ->appends(['tab' => $tab]); // This ensures pagination links remember the current tab

        return view('admin.enquiries.index', compact('enquiries', 'tab'));
    }

    // 3. ADMIN: Send the Reply
    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_response' => 'required|string'
        ]);

        $enquiry = Enquiry::findOrFail($id);
        
        // Update database
        $enquiry->update([
            'admin_response' => $request->admin_response,
            'status' => 'resolved'
        ]);

        // Send Email
        try {
            Mail::to($enquiry->email)->send(new EnquiryReply($enquiry));
        } catch (\Exception $e) {
            return back()->with('error', 'Reply saved, but the email failed to send: ' . $e->getMessage());
        }

        return back()->with('success', 'Reply sent successfully!');
    }
}