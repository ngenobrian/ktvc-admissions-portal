<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForcedPasswordController extends Controller
{
    public function show()
    {
        return view('auth.force-password-change');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        
        // Update password and remove the flag
        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        // Redirect based on whether they are a trainee or admin
        if ($user->hasAnyRole(['Super Admin', 'Registrar']) || $user->permissions->count() > 0) {
            return redirect()->route('admin.dashboard')->with('success', 'Password updated successfully. Welcome to the portal.');
        }

        return redirect()->route('dashboard')->with('success', 'Password updated successfully.');
    }
}
