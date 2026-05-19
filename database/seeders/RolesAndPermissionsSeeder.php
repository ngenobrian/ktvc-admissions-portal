<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create the core roles
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $registrarRole = Role::create(['name' => 'Registrar']);
        $traineeRole = Role::create(['name' => 'Trainee']);

        // Optional: Let's assign the Super Admin role to your first admin account 
        // (Assuming user ID 1 is your main admin account. Change the email to match yours!)
        $adminUser = User::where('email', 'admin@ktvc.ac.ke')->first();
        if ($adminUser) {
            $adminUser->assignRole($superAdminRole);
        }
    }
}
