<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordResetController extends Controller
{
    // 1. Show the form to request a reset link
    public function requestForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Send the reset link to the user's email
    public function sendEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Laravel's built-in broker generates the secure token and sends the email
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('success', 'We have emailed your password reset link!');
        }

        return back()->withErrors(['email' => __($status)]);
    }

    // 3. Show the form to create a new password (after they click the email link)
    public function resetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    // 4. Actually update the password in the database
    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect('/')->with('success', 'Your password has been reset! Please log in.');
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
