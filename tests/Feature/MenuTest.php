<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class MenuTest extends TestCase
{
    public function test_non_admin_user_sees_only_allowed_menus(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $adminUser = User::factory()->create();
        $adminUser->assignRole($adminRole);

        $regularUser = User::factory()->create();
        $regularUser->assignRole($userRole);

        $mainHeader = Menu::create(['name' => 'Main', 'type' => 'header', 'is_active' => true]);
        $mainHeader->roles()->attach([$adminRole->id, $userRole->id]);

        $dashboards = Menu::create(['name' => 'Dashboards', 'type' => 'item', 'is_active' => true]);
        $dashboards->roles()->attach([$adminRole->id, $userRole->id]);

        $appsHeader = Menu::create(['name' => 'Apps', 'type' => 'header', 'is_active' => true]);
        $appsHeader->roles()->attach([$adminRole->id]);

        $this->assertTrue($mainHeader->isVisibleForUser($regularUser));
        $this->assertTrue($dashboards->isVisibleForUser($regularUser));
        $this->assertFalse($appsHeader->isVisibleForUser($regularUser));

        $this->assertTrue($mainHeader->isVisibleForUser($adminUser));
        $this->assertTrue($dashboards->isVisibleForUser($adminUser));
        $this->assertTrue($appsHeader->isVisibleForUser($adminUser));
    }
}
