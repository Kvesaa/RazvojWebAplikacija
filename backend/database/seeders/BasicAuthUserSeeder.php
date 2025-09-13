<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class BasicAuthUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create basic auth user for v1 API
        $user = User::create([
            'name' => 'Basic Auth User',
            'email' => 'basic_user@example.com',
            'password' => Hash::make('basic_pass'),
            'email_verified_at' => now(),
        ]);
        
        // Assign admin role to basic auth user so they can access all endpoints
        $user->assignRole('admin');
    }
}

