<?php

namespace Database\Seeders;

use App\Models\Admin\System\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Users & User Profiles (1 Admin + 10 Users)
        $this->call(UserSeeder::class);

        // Seed app features
        $this->call(AppFeatureSeeder::class);

        // Seed dynamic database menus
        $this->call(MenuSeeder::class);
    }
}
