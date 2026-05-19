<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    // 1. List all users
    public function index()
    {
        // Fetch all users, eager loading their roles to prevent N+1 query issues, and paginate them
        $users = User::with('roles')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    // 2. Show the role assignment form
    public function edit(User $user)
    {
        // Get all available roles (Super Admin, Registrar, Trainee, etc.)
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // 3. Save the assigned roles
    public function update(Request $request, User $user)
    {
        // Validate that roles is an array
        $request->validate([
            'roles' => 'nullable|array'
        ]);

        // Sync the roles to the user. If $request->roles is null (all unchecked), pass an empty array.
        $user->syncRoles($request->roles ?? []);

        return redirect()->route('admin.users.index')->with('success', 'User roles updated successfully.');
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
}
