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
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();

        // 1. Check if the OTP matches (using loosely typed == to avoid string/integer conflicts)
        if ($user->otp_code != $request->otp) {
            return back()->withErrors(['otp' => 'The code you entered is incorrect.']);
        }

        // 2. Check if the OTP has expired
        if (\Carbon\Carbon::now()->isAfter($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'This code has expired. Please request a new one.']);
        }

        // 3. Success! Clear the OTP so it can't be reused, and mark the user as verified
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
            'email_verified_at' => now(), // Optional: if you are using Laravel's MustVerifyEmail
        ]);

        return redirect()->route('dashboard')->with('success', 'Email verified successfully! Welcome to KTVC.');
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