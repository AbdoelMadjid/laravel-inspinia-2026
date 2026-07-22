<?php

namespace Database\Seeders;

use App\Models\Admin\System\User;
use App\Models\Admin\System\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles if not existing
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // 1. Create 1 Administrator User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'points' => 100,
                'is_approved' => true,
            ]
        );
        $admin->assignRole($adminRole);
        $admin->getOrCreateProfile();

        // 2. Create 1 Primary Test User (User #1 of 10)
        $testUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'points' => 10,
                'is_approved' => true,
            ]
        );
        $testUser->assignRole($userRole);
        $testUser->getOrCreateProfile();

        // 3. Create 9 Additional Users using Factory (User #2 to #10)
        $users = User::factory(9)
            ->has(UserProfile::factory(), 'profile')
            ->create();

        foreach ($users as $user) {
            $user->assignRole($userRole);
        }
    }
}
