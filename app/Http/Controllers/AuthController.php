<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Show the Registration Page
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle the Registration Data
    public function register(Request $request)
    {
        // 1. Validate the incoming data
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // expects a 'password_confirmation' field
        ]);
        // 2. Extract a temporary name from the email (e.g., "john" from "john@example.com")
        $temporaryName = explode('@', $request->email)[0];

        // Generate the initial 6-digit OTP
        $otp = rand(100000, 999999);

        // 2. Create the User (Self-sponsored direct applicants)
        $user = User::create([
            'name' => $temporaryName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'trainee',
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(15),
        ]);

        // Send the email
        Mail::to($user->email)->send(new SendOtpMail($otp));

        // 4. Log the user in immediately
        Auth::login($user);

        // Redirect to the new OTP verification screen instead of the dashboard
        return redirect()->route('otp.verify');
    }

    // Show the Login Page
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle the Login Request
    // Handle the Login Request
    // Handle the Login Request
    public function login(Request $request)
    {
        // 1. Validate the input (We use 'login_id' to accept either Email or Index Number)
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Determine if the user inputted an Email or an Index Number
        $loginType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'index_number';

        // 3. Prepare the credentials array for Laravel Auth
        $credentials = [
            $loginType => $request->login_id,
            'password' => $request->password
        ];

        // 4. Attempt to log in (checking if "Remember Me" was checked)
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();

            // 🚨 THE NEW GATEKEEPER: Check if OTP is verified 🚨
            // We check if the email_verified_at timestamp is empty
            if (is_null($user->email_verified_at)) {
                
                // 1. Log them back out immediately
                Auth::logout();
                
                // 2. Store their email securely in the session for the OTP page
                $request->session()->put('verify_email', $user->email);

                // 3. Kick them back to the verification screen
                return redirect()->route('otp.verify')
                    ->with('error', 'Access Denied: You must verify your email address using the OTP code before logging in.');
            }

            // Check if this is a KUCCPS student who needs to change their password
            if ($user->requires_password_change) {
                // We will build this redirect later
                // return redirect()->route('password.change.prompt');
            }

            // TRAFFIC DIRECTOR: Check if the user is staff
            // (Routes anyone who is NOT a trainee to the admin dashboard)
            if ($user->role && strtolower($user->role) !== 'trainee') {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Logged in to Admin Portal.');
            }

            // DEFAULT: Send standard trainees to the trainee dashboard
            return redirect()->intended(route('dashboard'))->with('success', 'Logged in successfully.');
        }

        // 5. If login fails, redirect back with an error
        return back()->withErrors([
            'login_id' => 'The provided credentials do not match our records.',
        ])->onlyInput('login_id');
    }

    // Handle Logout
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}