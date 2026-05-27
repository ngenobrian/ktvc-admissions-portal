<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'active');

        if ($tab === 'archived') {
            // Fetch ONLY soft-deleted users
            $staff = User::onlyTrashed()->where('role', '!=', 'super_admin')->get();
        } else {
            // Fetch active users
            $staff = User::where('role', '!=', 'super_admin')->get();
        }

        return view('admin.staff.index', compact('staff', 'tab'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:20',
            'role' => 'required|in:admin,hod,staff',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'password' => Hash::make('password123'), // Default password
        ]);

        return back()->with('success', 'Staff member added successfully. Default password is: password123');
    }

    public function archive($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // This performs a "Soft Delete"

        return back()->with('success', 'Staff member archived and access revoked.');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore(); // This brings them back to active status

        return back()->with('success', 'Staff member restored successfully.');
    }
}