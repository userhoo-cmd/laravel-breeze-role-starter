<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create or update the admin user
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // Lookup criteria
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'), // Secure hashed password
                'is_admin' => 1, // Optional: mark as admin if your table has this column
            ]
        );
    }
}
