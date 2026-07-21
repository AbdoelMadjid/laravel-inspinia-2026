<?php

namespace Database\Seeders;

use App\Models\Admin\System\Menu;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean old template menus from database so only dynamic app menus exist
        Menu::query()->delete();
        // Ensure roles exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create core permissions
        $permissions = [
            'manage-menus',
            'manage-users',
            'manage-roles',
            'manage-permissions',
            'manage-backups',
            'manage-app-features',
            'view-dashboards',
            'view-apps',
            'view-pages',
            'view-components',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Give all permissions to adminRole
        $adminRole->givePermissionTo(Permission::all());

        // Dynamic Application Menus
        $appMenus = [
            // --- DASHBOARD (Top level, no header) ---
            [
                'name' => 'Dashboard',
                'type' => 'item',
                'icon' => 'ti ti-dashboard',
                'route_name' => 'dashboard',
                'data_lang' => 'dashboard',
                'sort_order' => 1,
                'roles' => [$adminRole, $userRole],
            ],

            // --- SYSTEM MANAGEMENT HEADER ---
            [
                'name' => 'System Management',
                'type' => 'header',
                'data_lang' => 'system-management',
                'sort_order' => 2,
                'roles' => [$adminRole, $userRole],
            ],
            [
                'name' => 'Profile',
                'type' => 'item',
                'icon' => 'ti ti-user-circle',
                'route_name' => 'page',
                'route_params' => ['page' => 'profile-page'],
                'data_lang' => 'profile',
                'sort_order' => 3,
                'roles' => [$adminRole, $userRole],
            ],
            [
                'name' => 'Apps Management',
                'type' => 'item',
                'icon' => 'ti ti-apps',
                'data_lang' => 'apps-management',
                'sort_order' => 4,
                'roles' => [$adminRole],
                'children' => [
                    [
                        'name' => 'Menu',
                        'type' => 'item',
                        'icon' => 'ti ti-list-check',
                        'route_name' => 'admin.menus.index',
                        'permission_name' => 'manage-menus',
                        'data_lang' => 'menu-management',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Fitur Apps',
                        'type' => 'item',
                        'icon' => 'ti ti-toggle-right',
                        'route_name' => 'admin.app-features.index',
                        'permission_name' => 'manage-app-features',
                        'data_lang' => 'apps-features',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Backup Database',
                        'type' => 'item',
                        'icon' => 'ti ti-database-export',
                        'route_name' => 'admin.backups.index',
                        'permission_name' => 'manage-backups',
                        'data_lang' => 'apps-backup-database',
                        'sort_order' => 3,
                    ],
                ],
            ],
            [
                'name' => 'Users Management',
                'type' => 'item',
                'icon' => 'ti ti-users-group',
                'permission_name' => 'manage-users',
                'data_lang' => 'users-management',
                'sort_order' => 5,
                'roles' => [$adminRole],
                'children' => [
                    ['name' => 'Contacts / Users', 'type' => 'item', 'route_name' => 'admin.users.index', 'data_lang' => 'users-contacts', 'sort_order' => 1],
                    ['name' => 'Roles', 'type' => 'item', 'route_name' => 'admin.roles.index', 'data_lang' => 'users-roles', 'sort_order' => 2],
                    ['name' => 'Permissions', 'type' => 'item', 'route_name' => 'admin.permissions.index', 'data_lang' => 'users-permissions', 'sort_order' => 3],
                ],
            ],
        ];

        // Seed or update menus idempotently
        $this->seedMenuTree($appMenus);
    }

    /**
     * Seed menu tree using updateOrCreate.
     */
    protected function seedMenuTree(array $items, ?int $parentId = null): void
    {
        foreach ($items as $index => $itemData) {
            $menu = Menu::updateOrCreate(
                [
                    'name' => $itemData['name'],
                    'parent_id' => $parentId,
                ],
                [
                    'type' => $itemData['type'] ?? 'item',
                    'icon' => $itemData['icon'] ?? null,
                    'route_name' => $itemData['route_name'] ?? null,
                    'route_params' => $itemData['route_params'] ?? null,
                    'url' => $itemData['url'] ?? null,
                    'badge_text' => $itemData['badge_text'] ?? null,
                    'badge_class' => $itemData['badge_class'] ?? 'badge bg-primary-subtle text-primary',
                    'permission_name' => $itemData['permission_name'] ?? null,
                    'data_lang' => $itemData['data_lang'] ?? null,
                    'is_active' => $itemData['is_active'] ?? true,
                    'sort_order' => $itemData['sort_order'] ?? ($index + 1),
                ]
            );

            // Sync roles if defined
            if (isset($itemData['roles'])) {
                $roleIds = collect($itemData['roles'])->pluck('id')->toArray();
                $menu->roles()->sync($roleIds);
            }

            // Seed children recursively
            if (!empty($itemData['children'])) {
                $this->seedMenuTree($itemData['children'], $menu->id);
            }
        }
    }
}
