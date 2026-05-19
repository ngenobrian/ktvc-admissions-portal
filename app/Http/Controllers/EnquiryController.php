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

    // 2. ADMIN: List all Enquiries
    public function index()
    {
        // Fetch enquiries, showing the newest ones first
        $enquiries = Enquiry::latest()->paginate(15);
        return view('admin.enquiries.index', compact('enquiries'));
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