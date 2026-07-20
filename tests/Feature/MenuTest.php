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
    public function test_menu_hierarchy_and_spatie_role_visibility(): void
    {
        $adminRole = Role::create(['name' => 'admin_test']);
        $userRole = Role::create(['name' => 'user_test']);
        $permission = Permission::create(['name' => 'secret-menu-permission']);

        $adminRole->givePermissionTo($permission);

        $rootMenu = Menu::create([
            'name' => 'Root Menu',
            'type' => 'item',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        $rootMenu->roles()->attach([$adminRole->id, $userRole->id]);

        $adminOnlyChild = Menu::create([
            'parent_id' => $rootMenu->id,
            'name' => 'Admin Only Submenu',
            'type' => 'item',
            'permission_name' => 'secret-menu-permission',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $user = User::factory()->create();
        $admin = User::factory()->create();
        $admin->assignRole($adminRole);
        $user->assignRole($userRole);

        // Admin should see secret menu
        $this->assertTrue($adminOnlyChild->isVisibleForUser($admin));

        // Regular user should not see secret menu
        $this->assertFalse($adminOnlyChild->isVisibleForUser($user));
    }
}
