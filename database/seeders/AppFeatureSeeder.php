<?php

namespace Database\Seeders;

use App\Models\AppFeature;
use Illuminate\Database\Seeder;

class AppFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'name' => 'Topbar Search Bar',
                'key' => 'topbar_search',
                'category' => 'topbar',
                'description' => 'Menampilkan kotak pencarian di topbar sebelah kiri',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Topbar Mega Menu',
                'key' => 'topbar_mega_menu',
                'category' => 'topbar',
                'description' => 'Menampilkan dropdown Mega Menu di topbar sebelah kiri',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Topbar Apps Dropdown',
                'key' => 'topbar_apps_menu',
                'category' => 'topbar',
                'description' => 'Menampilkan dropdown Apps di topbar sebelah kiri',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Sidebar Profil User',
                'key' => 'sidebar_user_profile',
                'category' => 'sidebar',
                'description' => 'Menampilkan kotak profil & foto user di bagian atas sidebar',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Menu Template & Demo',
                'key' => 'template_menus',
                'category' => 'sidebar',
                'description' => 'Menampilkan kelompok menu template & demo di sidebar',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Topbar Light/Dark Mode',
                'key' => 'topbar_theme_toggler',
                'category' => 'topbar',
                'description' => 'Menampilkan ikon tombol pengubah tema Terang/Gelap (Light/Dark Mode) di sebelah kiri foto user',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Topbar Apps Grid',
                'key' => 'topbar_apps_grid',
                'category' => 'topbar',
                'description' => 'Menampilkan ikon grid aplikasi (Google, Figma, Slack, Dropbox, dll) di topbar kanan',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Topbar Messages Dropdown',
                'key' => 'topbar_messages',
                'category' => 'topbar',
                'description' => 'Menampilkan ikon email / pesan masuk di topbar kanan',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Topbar Notifications Dropdown',
                'key' => 'topbar_notifications',
                'category' => 'topbar',
                'description' => 'Menampilkan ikon lonceng notifikasi & alert di topbar kanan',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Topbar Fullscreen Toggle',
                'key' => 'topbar_fullscreen',
                'category' => 'topbar',
                'description' => 'Menampilkan ikon tombol layar penuh (Fullscreen) di topbar kanan',
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'name' => 'Topbar Monochrome Mode',
                'key' => 'topbar_monochrome',
                'category' => 'topbar',
                'description' => 'Menampilkan ikon mode monokrom (Palette) di topbar kanan',
                'is_active' => true,
                'sort_order' => 11,
            ],
            [
                'name' => 'Topbar Customizer / Settings',
                'key' => 'topbar_customizer',
                'category' => 'topbar',
                'description' => 'Menampilkan ikon roda gigi pengaturan tema (Customizer) di topbar kanan',
                'is_active' => true,
                'sort_order' => 12,
            ],
            [
                'name' => 'Topbar Language Selector',
                'key' => 'topbar_language',
                'category' => 'topbar',
                'description' => 'Menampilkan ikon pemilih bahasa (Language EN / ID) di topbar kanan',
                'is_active' => true,
                'sort_order' => 13,
            ],
        ];

        foreach ($features as $feat) {
            AppFeature::updateOrCreate(
                ['key' => $feat['key']],
                $feat
            );
        }
    }
}
