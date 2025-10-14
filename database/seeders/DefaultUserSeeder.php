<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DefaultUserSeeder extends Seeder
{
    public function run(): void
    {
        // Clear Spatie cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Ensure roles exist (you already have these in your DB)
        $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdmin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $customerRole = Role::firstOrCreate(['name' => 'Customer']);

        // --- Create default users ---
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'password' => Hash::make('password'),
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        $admin = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'first_name' => 'Manager',
                'last_name' => 'User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole($adminRole);

        $customer = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'first_name' => 'Customer',
                'last_name' => 'Guest',
                'password' => Hash::make('password'),
            ]
        );
        $customer->assignRole($customerRole);

        $this->command->info('✅ Default users created and roles assigned successfully.');
    }
}
