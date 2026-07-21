<?php

namespace Database\Seeders;

use App\Models\Admin\System\Menu;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AppMenuSeeder extends Seeder
{
    /**
     * Run the database seeds for application-specific menus.
     * 
     * Seeder ini khusus digunakan untuk menambahkan menu-menu aplikasi custom
     * yang dibutuhkan saat membangun aplikasi.
     * Menu di sini akan berada di atas 'MAIN MENU' (sort_order antara 10 - 99).
     */
    public function run(): void
    {
        // Pastikan role dasar ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Hapus menu aplikasi sebelumnya (sort_order 10 s/d 99)
        Menu::whereBetween('sort_order', [10, 99])->delete();

        // Struktur menu aplikasi custom (Tambahkan menu aplikasi Anda di sini saat dibutuhkan)
        $appMenuTree = [
            /*
            // Contoh menambahkan Header & Menu Aplikasi:
            [
                'name' => 'Application',
                'type' => 'header',
                'data_lang' => 'application-header',
                'sort_order' => 10,
                'roles' => [$adminRole, $userRole],
            ],
            [
                'name' => 'Master Data',
                'type' => 'item',
                'icon' => 'ti ti-database',
                'data_lang' => 'master-data',
                'sort_order' => 11,
                'roles' => [$adminRole, $userRole],
                'children' => [
                    [
                        'name' => 'Kategori',
                        'type' => 'item',
                        'route_name' => 'categories.index',
                        'data_lang' => 'kategori',
                        'sort_order' => 1,
                    ],
                ],
            ],
            */
        ];

        if (!empty($appMenuTree)) {
            $this->saveMenuTree($appMenuTree, null, [$adminRole, $userRole]);
        }
    }

    /**
     * Fungsi rekursif untuk menyimpan hirarki menu beserta sync Spatie Roles.
     */
    private function saveMenuTree(array $items, ?int $parentId = null, array $defaultRoles = []): void
    {
        foreach ($items as $itemData) {
            $children = $itemData['children'] ?? [];
            $rolesToAssign = $itemData['roles'] ?? $defaultRoles;
            unset($itemData['children'], $itemData['roles']);

            $itemData['parent_id'] = $parentId;
            $itemData['is_active'] = $itemData['is_active'] ?? true;
            $itemData['target'] = $itemData['target'] ?? '_self';

            $menu = Menu::create($itemData);

            if (!empty($rolesToAssign)) {
                $menu->roles()->sync(collect($rolesToAssign)->pluck('id')->toArray());
            }

            if (!empty($children)) {
                $this->saveMenuTree($children, $menu->id, $rolesToAssign);
            }
        }
    }
}
