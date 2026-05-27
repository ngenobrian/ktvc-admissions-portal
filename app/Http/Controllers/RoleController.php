<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // The master list of available permissions in your system
    const AVAILABLE_PERMISSIONS = [
        'view_analytics' => 'View Dashboard Analytics',
        'review_applications' => 'Review Student Applications',
        'manage_enquiries' => 'Reply To Enquiries',
        'manage_staff' => 'Manage System Staff',
        'export_data' => 'Export Approved Students / Data',
    ];

    public function index()
    {
        $roles = Role::withCount('users')->get(); // We will add the relationship to User model shortly
        $availablePermissions = self::AVAILABLE_PERMISSIONS;
        
        return view('admin.roles.index', compact('roles', 'availablePermissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'permissions' => 'nullable|array',
        ]);

        Role::create([
            'name' => $request->name,
            'permissions' => $request->permissions ?? [], // Save selected checkboxes as JSON
        ]);

        return back()->with('success', 'Role created successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        
        if ($role->name === 'super_admin') {
            return back()->with('error', 'Cannot delete the Super Admin role.');
        }

        $role->delete();
        return back()->with('success', 'Role deleted.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        
        // Prevent accidental editing of the master super_admin role
        if ($role->name === 'super_admin') {
            return back()->with('error', 'The Super Admin role is hardcoded and cannot be edited.');
        }

        $availablePermissions = self::AVAILABLE_PERMISSIONS;
        
        return view('admin.roles.edit', compact('role', 'availablePermissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'super_admin') {
            return back()->with('error', 'The Super Admin role cannot be edited.');
        }

        // Validate, allowing the name to remain the same without triggering the 'unique' error
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'permissions' => 'nullable|array',
        ]);

        $role->update([
            'name' => $request->name,
            'permissions' => $request->permissions ?? [], // Save new JSON array
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role permissions updated successfully.');
    }
}
