<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Check if admin already exists
        $admin = User::where('email', 'admin@example.com')->first();

        if (!$admin) {
            User::create([
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@example.com',
                'password' => Hash::make('Admin@123!'), // <-- known secure password
                'is_admin' => 1,
            ]);
        } else {
            // Optional: update password to known one
            $admin->password = Hash::make('Admin@123!');
            $admin->save();
        }
    }
}
