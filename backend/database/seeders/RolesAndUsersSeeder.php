<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'read-airport',
            'create-airport',
            'update-airport',
            'delete-airport',
            'read-airline',
            'create-airline',
            'update-airline',
            'delete-airline',
            'read-flight',
            'create-flight',
            'update-flight',
            'delete-flight',
            'read-airplane',
            'create-airplane',
            'update-airplane',
            'delete-airplane',
            'read-booking',
            'create-booking',
            'update-booking',
            'delete-booking',
            'read-passenger',
            'create-passenger',
            'update-passenger',
            'delete-passenger',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles
        $readerRole = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $authorRole = Role::create(['name' => 'author', 'guard_name' => 'web']);
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);

        // Assign permissions to roles
        $readerPermissions = [
            'read-airport', 'read-airline', 'read-flight', 'read-airplane', 
            'read-booking', 'read-passenger'
        ];
        $readerRole->givePermissionTo($readerPermissions);

        $authorPermissions = [
            'read-airport', 'read-airline', 'read-flight', 'read-airplane', 
            'read-booking', 'read-passenger',
            'create-airport', 'create-airline', 'create-flight', 'create-airplane', 
            'create-booking', 'create-passenger'
        ];
        $authorRole->givePermissionTo($authorPermissions);

        $adminPermissions = [
            'read-airport', 'read-airline', 'read-flight', 'read-airplane', 
            'read-booking', 'read-passenger',
            'create-airport', 'create-airline', 'create-flight', 'create-airplane', 
            'create-booking', 'create-passenger',
            'update-airport', 'update-airline', 'update-flight', 'update-airplane', 
            'update-booking', 'update-passenger',
            'delete-airport', 'delete-airline', 'delete-flight', 'delete-airplane', 
            'delete-booking', 'delete-passenger'
        ];
        $adminRole->givePermissionTo($adminPermissions);

        // Create users
        $reader = User::create([
            'name' => 'Reader User',
            'email' => 'reader@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $reader->assignRole('reader');

        $author = User::create([
            'name' => 'Author User',
            'email' => 'author@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $author->assignRole('author');

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');
    }
}

