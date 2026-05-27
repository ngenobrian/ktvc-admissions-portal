<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    // 1. List all users
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'active');

        if ($tab === 'archived') {
            // Fetch ONLY soft-deleted users (ignoring super admins so you don't lock yourself out)
            $users = \App\Models\User::onlyTrashed()->where('role', '!=', 'super_admin')->latest()->paginate(15);
        } else {
            // Fetch active users
            $users = \App\Models\User::where('role', '!=', 'super_admin')->latest()->paginate(15);
        }

        return view('admin.users.index', compact('users', 'tab'));
    }

    // 2. Show the role assignment form
    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        // Fetch all dynamic roles we created in the Roles system
        $roles = \App\Models\Role::all(); 
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        // 1. Validate ONLY the role, since that is all our form sends
        $request->validate([
            'role' => 'required|string',
        ]);

        // 2. Update ONLY the role in the database
        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User role updated successfully!');
    }

    public function create()
    {
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('admin.users.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'job_title' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'permissions' => 'nullable|array'
        ]);

        // Create the user with default password and forced change flag
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'job_title' => $request->job_title,
            'department' => $request->department,
            'password' => bcrypt('Password@2026'), 
            'must_change_password' => true,
        ]);

        // Assign selected permissions directly to the user
        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.users.index')->with('success', 'Staff member created successfully. Default password is Password@2026');
    }

    public function archive($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete(); // This performs the Soft Delete

        return back()->with('success', 'User archived and access revoked.');
    }

    public function restore($id)
    {
        $user = \App\Models\User::withTrashed()->findOrFail($id);
        $user->restore(); // Brings them back to active status

        return back()->with('success', 'User access restored successfully.');
    }
}
