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
            'manage-app-profile',
            'manage-login-logs',
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
                'name_en' => 'Dashboard',
                'name_id' => 'Dasbor',
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
                'name_en' => 'System Management',
                'name_id' => 'Manajemen Sistem',
                'type' => 'header',
                'data_lang' => 'system-management',
                'sort_order' => 2,
                'roles' => [$adminRole, $userRole],
            ],
            [
                'name' => 'Profile',
                'name_en' => 'Profile',
                'name_id' => 'Profil Saya',
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
                'name_en' => 'Apps Management',
                'name_id' => 'Manajemen Aplikasi',
                'type' => 'item',
                'icon' => 'ti ti-apps',
                'data_lang' => 'apps-management',
                'sort_order' => 4,
                'roles' => [$adminRole],
                'children' => [
                    [
                        'name' => 'Menu',
                        'name_en' => 'Menu Management',
                        'name_id' => 'Manajemen Menu',
                        'type' => 'item',
                        'route_name' => 'admin.menus.index',
                        'permission_name' => 'manage-menus',
                        'data_lang' => 'menu-management',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Apps Profile',
                        'name_en' => 'Apps Profile',
                        'name_id' => 'Profil Aplikasi',
                        'type' => 'item',
                        'route_name' => 'admin.app-profile.index',
                        'permission_name' => 'manage-app-profile',
                        'data_lang' => 'apps-profile',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Fitur Apps',
                        'name_en' => 'App Features',
                        'name_id' => 'Fitur Aplikasi',
                        'type' => 'item',
                        'route_name' => 'admin.app-features.index',
                        'permission_name' => 'manage-app-features',
                        'data_lang' => 'apps-features',
                        'sort_order' => 3,
                    ],
                    [
                        'name' => 'Backup Database',
                        'name_en' => 'Database Backup',
                        'name_id' => 'Cadangan Database',
                        'type' => 'item',
                        'route_name' => 'admin.backups.index',
                        'permission_name' => 'manage-backups',
                        'data_lang' => 'apps-backup-database',
                        'sort_order' => 4,
                    ],
                    [
                        'name' => 'Data Login',
                        'name_en' => 'Login Data',
                        'name_id' => 'Data Login',
                        'type' => 'item',
                        'route_name' => 'admin.login-logs.index',
                        'permission_name' => 'manage-login-logs',
                        'data_lang' => 'apps-login-logs',
                        'sort_order' => 5,
                    ],

                ],
            ],
            [
                'name' => 'Users Setting',
                'name_en' => 'Users Setting',
                'name_id' => 'Pengaturan User',
                'type' => 'item',
                'icon' => 'ti ti-users-group',
                'permission_name' => 'manage-users',
                'data_lang' => 'users-setting',
                'sort_order' => 5,
                'roles' => [$adminRole],
                'children' => [
                    ['name' => 'Contacts / Users', 'name_en' => 'Contacts / Users', 'name_id' => 'Kontak / Pengguna', 'type' => 'item', 'route_name' => 'admin.users.index', 'data_lang' => 'users-contacts', 'sort_order' => 1],
                    ['name' => 'Roles', 'name_en' => 'Roles', 'name_id' => 'Peran Pengguna', 'type' => 'item', 'route_name' => 'admin.roles.index', 'data_lang' => 'users-roles', 'sort_order' => 2],
                    ['name' => 'Permissions', 'name_en' => 'Permissions', 'name_id' => 'Izin Akses', 'type' => 'item', 'route_name' => 'admin.permissions.index', 'data_lang' => 'users-permissions', 'sort_order' => 3],
                ],
            ],
        ];

        // Seed or update menus idempotently
        $this->seedMenuTree($appMenus);
    }

    /**
     * Seed menu tree using updateOrCreate and auto-sync translations.
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

            // Auto-sync translation key to en.json and id.json if data_lang is set
            if (!empty($itemData['data_lang'])) {
                $textEn = $itemData['name_en'] ?? $itemData['name'];
                $textId = $itemData['name_id'] ?? $itemData['name'];
                $this->syncTranslationKey($itemData['data_lang'], $textEn, $textId);
            }

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

    /**
     * Automatically update or append translation keys to en.json and id.json.
     */
    protected function syncTranslationKey(string $key, string $textEn, string $textId): void
    {
        $enPath = public_path('assets/data/translations/en.json');
        $idPath = public_path('assets/data/translations/id.json');

        if (file_exists($enPath)) {
            $enJson = json_decode(file_get_contents($enPath), true) ?: [];
            if (!isset($enJson[$key]) || $enJson[$key] !== $textEn) {
                $enJson[$key] = $textEn;
                file_put_contents($enPath, json_encode($enJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }

        if (file_exists($idPath)) {
            $idJson = json_decode(file_get_contents($idPath), true) ?: [];
            if (!isset($idJson[$key]) || $idJson[$key] !== $textId) {
                $idJson[$key] = $textId;
                file_put_contents($idPath, json_encode($idJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }
    }
}
