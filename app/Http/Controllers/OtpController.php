<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use Carbon\Carbon;

class OtpController extends Controller
{
    // Show the verification screen
    public function showVerifyForm()
    {
        // If already verified, send them to dashboard
        if (Auth::user()->email_verified_at) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-otp');
    }

    // Process the code entered by the user
    public function verify(Request $request)
    {
        // 1. Validate the incoming OTP from the form
        $request->validate([
            'otp' => 'required|string',
        ]);

        // 2. Retrieve the email we temporarily stored in the session
        $email = $request->session()->get('verify_email');

        // Safety Check: If the session expired or is missing, send them back to login
        if (!$email) {
            return redirect()->route('login')->with('error', 'Verification session expired. Please log in to request a new code.');
        }

        // 3. Find the user in the database
        $user = \App\Models\User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found.');
        }

        // 4. Check if the provided OTP matches the database
        if ((string) $user->otp !== (string) $request->otp) {
            return back()->with('error', 'The verification code you entered is incorrect.');
        }

        // 5. SUCCESS! Mark the email as verified and clear the OTP for security
        $user->email_verified_at = now();
        $user->otp = null;
        $user->save();

        // 6. Log the user into the application
        \Illuminate\Support\Facades\Auth::login($user);

        // 7. Clear the temporary email from the session so it can't be reused
        $request->session()->forget('verify_email');

        // 8. TRAFFIC DIRECTOR: Send them to the correct dashboard
        if ($user->role && strtolower($user->role) !== 'trainee') {
            return redirect()->route('admin.dashboard')->with('success', 'Email verified successfully! Welcome to the Admin Portal.');
        }

        return redirect()->route('dashboard')->with('success', 'Email verified successfully! Welcome to the KTVC Admissions Portal.');
    }

    // Generate and send a new code
    public function resend()
    {
        $user = Auth::user();

        // Generate 6 random digits
        $newOtp = rand(100000, 999999);

        // Save to database with 15 min expiry
        $user->otp_code = $newOtp;
        $user->otp_expires_at = Carbon::now()->addMinutes(15);
        $user->save();

        // Send Email
        Mail::to($user->email)->send(new SendOtpMail($newOtp));

        return back()->with('success', 'A new verification code has been sent to your email.');
    }
}