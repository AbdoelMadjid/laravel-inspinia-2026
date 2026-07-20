<?php

namespace Database\Seeders;

use App\Models\Menu;
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
        // Clear existing menus
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

        // Give manage-menus permission to adminRole
        $adminRole->givePermissionTo(Permission::all());

        // Structure of menu items to seed
        $menuTree = [
            // --- SINGLE DASHBOARD MENU (Top level, no header) ---
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
                'children' => [
                    ['name' => 'Contacts / Users', 'type' => 'item', 'route_name' => 'admin.users.index', 'data_lang' => 'users-contacts', 'sort_order' => 1],
                    ['name' => 'Roles', 'type' => 'item', 'route_name' => 'admin.roles.index', 'data_lang' => 'users-roles', 'sort_order' => 2],
                    ['name' => 'Permissions', 'type' => 'item', 'route_name' => 'admin.permissions.index', 'data_lang' => 'users-permissions', 'sort_order' => 3],
                ],
            ],

            // --- MAIN MENU HEADER (TEMPLATE MENUS) ---
            [
                'name' => 'Main Menu',
                'type' => 'header',
                'data_lang' => 'main-menu',
                'sort_order' => 100,
                'roles' => [$adminRole],
            ],
            [
                'name' => 'Dashboards',
                'type' => 'item',
                'icon' => 'ti ti-layout-grid',
                'data_lang' => 'dashboards',
                'sort_order' => 101,
                'roles' => [$adminRole],
                'children' => [
                    [
                        'name' => 'Ecommerce',
                        'type' => 'item',
                        'route_name' => 'page',
                        'route_params' => ['page' => 'dashboard-ecommerce'],
                        'data_lang' => 'dashboard-ecommerce',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Analytics',
                        'type' => 'item',
                        'route_name' => 'page',
                        'route_params' => ['page' => 'dashboard-analytics'],
                        'data_lang' => 'dashboard-analytics',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Projects',
                        'type' => 'item',
                        'route_name' => 'page',
                        'route_params' => ['page' => 'dashboard-projects'],
                        'data_lang' => 'dashboard-projects',
                        'sort_order' => 3,
                    ],
                ],
            ],
            [
                'name' => 'Landing',
                'type' => 'item',
                'icon' => 'ti ti-rocket',
                'route_name' => 'page',
                'route_params' => ['page' => 'landing'],
                'data_lang' => 'landing',
                'sort_order' => 102,
                'roles' => [$adminRole],
            ],

            // --- APPS HEADER ---
            [
                'name' => 'Apps',
                'type' => 'header',
                'data_lang' => 'apps',
                'sort_order' => 200,
            ],
            [
                'name' => 'Ecommerce',
                'type' => 'item',
                'icon' => 'ti ti-basket',
                'data_lang' => 'ecommerce',
                'sort_order' => 201,
                'children' => [
                    ['name' => 'Marketplace', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-marketplace'], 'data_lang' => 'apps-ecommerce-marketplace', 'sort_order' => 1],
                    [
                        'name' => 'Products',
                        'type' => 'item',
                        'data_lang' => 'products',
                        'sort_order' => 2,
                        'children' => [
                            ['name' => 'Products', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-products'], 'data_lang' => 'apps-ecommerce-products', 'sort_order' => 1],
                            ['name' => 'Products Grid', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-products-grid'], 'data_lang' => 'apps-ecommerce-products-grid', 'sort_order' => 2],
                            ['name' => 'Product Details', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-product-details'], 'data_lang' => 'apps-ecommerce-product-details', 'sort_order' => 3],
                            ['name' => 'Add Product', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-product-add'], 'data_lang' => 'apps-ecommerce-product-add', 'sort_order' => 4],
                        ],
                    ],
                    ['name' => 'Categories', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-categories'], 'data_lang' => 'apps-ecommerce-categories', 'sort_order' => 3],
                    [
                        'name' => 'Orders',
                        'type' => 'item',
                        'data_lang' => 'orders',
                        'sort_order' => 4,
                        'children' => [
                            ['name' => 'Orders', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-orders'], 'data_lang' => 'apps-ecommerce-orders', 'sort_order' => 1],
                            ['name' => 'Order Details', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-order-details'], 'data_lang' => 'apps-ecommerce-order-details', 'sort_order' => 2],
                            ['name' => 'Add/Edit Order', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-order-add'], 'data_lang' => 'apps-ecommerce-order-add', 'sort_order' => 3],
                        ],
                    ],
                    ['name' => 'Customers', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-customers'], 'data_lang' => 'apps-ecommerce-customers', 'sort_order' => 5],
                    ['name' => 'Cart', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-cart'], 'data_lang' => 'apps-ecommerce-cart', 'sort_order' => 6],
                    ['name' => 'Checkout', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-checkout'], 'data_lang' => 'apps-ecommerce-checkout', 'sort_order' => 7],
                    [
                        'name' => 'Sellers',
                        'type' => 'item',
                        'data_lang' => 'sellers',
                        'sort_order' => 8,
                        'children' => [
                            ['name' => 'Sellers', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-sellers'], 'data_lang' => 'apps-ecommerce-sellers', 'sort_order' => 1],
                            ['name' => 'Sellers Details', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-seller-details'], 'data_lang' => 'apps-ecommerce-seller-details', 'sort_order' => 2],
                        ],
                    ],
                    ['name' => 'Refunds', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-refunds'], 'data_lang' => 'apps-ecommerce-refunds', 'sort_order' => 9],
                    ['name' => 'Reviews', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-reviews'], 'data_lang' => 'apps-ecommerce-reviews', 'sort_order' => 10],
                    [
                        'name' => 'Inventory',
                        'type' => 'item',
                        'data_lang' => 'inventory',
                        'sort_order' => 11,
                        'children' => [
                            ['name' => 'Warehouse', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-warehouse'], 'data_lang' => 'apps-ecommerce-warehouse', 'sort_order' => 1],
                            ['name' => 'Product Stocks', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-product-stocks'], 'data_lang' => 'apps-ecommerce-product-stocks', 'sort_order' => 2],
                            ['name' => 'Purchased Orders', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-purchased-orders'], 'data_lang' => 'apps-ecommerce-purchased-orders', 'sort_order' => 3],
                        ],
                    ],
                    [
                        'name' => 'Reports',
                        'type' => 'item',
                        'data_lang' => 'reports',
                        'sort_order' => 12,
                        'children' => [
                            ['name' => 'Product Views', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-product-views'], 'data_lang' => 'apps-ecommerce-product-views', 'sort_order' => 1],
                            ['name' => 'Sales', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-sales'], 'data_lang' => 'apps-ecommerce-sales', 'sort_order' => 2],
                        ],
                    ],
                    ['name' => 'Attributes', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-attributes'], 'data_lang' => 'apps-ecommerce-attributes', 'sort_order' => 13],
                    ['name' => 'Settings', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-ecommerce-settings'], 'data_lang' => 'apps-ecommerce-settings', 'sort_order' => 14],
                ],
            ],
            [
                'name' => 'Email',
                'type' => 'item',
                'icon' => 'ti ti-mailbox',
                'badge_text' => 'New',
                'badge_class' => 'badge bg-danger text-white float-end',
                'data_lang' => 'email',
                'sort_order' => 202,
                'children' => [
                    ['name' => 'Inbox', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-email-inbox'], 'data_lang' => 'apps-email-inbox', 'sort_order' => 1],
                    ['name' => 'Details', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-email-details'], 'data_lang' => 'apps-email-details', 'sort_order' => 2],
                    ['name' => 'Compose', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-email-compose'], 'data_lang' => 'apps-email-compose', 'sort_order' => 3],
                ],
            ],
            [
                'name' => 'Users',
                'type' => 'item',
                'icon' => 'ti ti-users',
                'data_lang' => 'users',
                'sort_order' => 203,
                'children' => [
                    ['name' => 'Contacts', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-users-contacts'], 'data_lang' => 'apps-users-contacts', 'sort_order' => 1],
                    ['name' => 'Roles', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-users-roles'], 'data_lang' => 'apps-users-roles', 'sort_order' => 2],
                    ['name' => 'Role Details', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-users-role-details'], 'data_lang' => 'apps-users-role-details', 'sort_order' => 3],
                    ['name' => 'Permissions', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-users-permissions'], 'data_lang' => 'apps-users-permissions', 'sort_order' => 4],
                ],
            ],
            [
                'name' => 'Projects',
                'type' => 'item',
                'icon' => 'ti ti-briefcase',
                'data_lang' => 'projects',
                'sort_order' => 204,
                'children' => [
                    ['name' => 'My Projects', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-projects-grid'], 'data_lang' => 'apps-projects-grid', 'sort_order' => 1],
                    ['name' => 'Projects List', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-projects-list'], 'data_lang' => 'apps-projects-list', 'sort_order' => 2],
                    ['name' => 'View Project', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-projects-details'], 'data_lang' => 'apps-projects-details', 'sort_order' => 3],
                    ['name' => 'Kanban Board', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-projects-kanban'], 'data_lang' => 'apps-projects-kanban', 'sort_order' => 4],
                    ['name' => 'Team Board', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-projects-team-board'], 'data_lang' => 'apps-projects-team-board', 'sort_order' => 5],
                    ['name' => 'Activity Steam', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-projects-activity'], 'data_lang' => 'apps-projects-activity', 'sort_order' => 6],
                ],
            ],
            ['name' => 'File Manager', 'type' => 'item', 'icon' => 'ti ti-folder-open', 'route_name' => 'page', 'route_params' => ['page' => 'apps-file-manager'], 'data_lang' => 'apps-file-manager', 'sort_order' => 205],
            ['name' => 'Chat', 'type' => 'item', 'icon' => 'ti ti-message', 'route_name' => 'page', 'route_params' => ['page' => 'apps-chat'], 'data_lang' => 'apps-chat', 'sort_order' => 206],
            ['name' => 'Calendar', 'type' => 'item', 'icon' => 'ti ti-calendar', 'route_name' => 'page', 'route_params' => ['page' => 'apps-calendar'], 'data_lang' => 'apps-calendar', 'sort_order' => 207],
            ['name' => 'Social Feed', 'type' => 'item', 'icon' => 'ti ti-rss', 'route_name' => 'page', 'route_params' => ['page' => 'apps-social-feed'], 'data_lang' => 'apps-social-feed', 'sort_order' => 208],
            [
                'name' => 'Invoice',
                'type' => 'item',
                'icon' => 'ti ti-invoice',
                'data_lang' => 'invoice',
                'sort_order' => 209,
                'children' => [
                    ['name' => 'Invoices', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-invoice-list'], 'data_lang' => 'apps-invoice-list', 'sort_order' => 1],
                    ['name' => 'Single Invoice', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-invoice-details'], 'data_lang' => 'apps-invoice-details', 'sort_order' => 2],
                    ['name' => 'New Invoice', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'apps-invoice-create'], 'data_lang' => 'apps-invoice-create', 'sort_order' => 3],
                ],
            ],
            ['name' => 'Companies', 'type' => 'item', 'icon' => 'ti ti-building', 'route_name' => 'page', 'route_params' => ['page' => 'apps-companies'], 'data_lang' => 'apps-companies', 'sort_order' => 210],

            // --- CUSTOM PAGES HEADER ---
            [
                'name' => 'Custom Pages',
                'type' => 'header',
                'data_lang' => 'custom-pages',
                'sort_order' => 400,
            ],
            [
                'name' => 'Pages',
                'type' => 'item',
                'icon' => 'ti ti-files',
                'data_lang' => 'pages',
                'sort_order' => 401,
                'children' => [
                    ['name' => 'Profile', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'pages-profile'], 'data_lang' => 'pages-profile', 'sort_order' => 1],
                    ['name' => 'Account Settings', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'pages-account-settings'], 'data_lang' => 'pages-account-settings', 'sort_order' => 2],
                    ['name' => 'FAQ', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'pages-faq'], 'data_lang' => 'pages-faq', 'sort_order' => 3],
                    ['name' => 'Pricing', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'pages-pricing'], 'data_lang' => 'pages-pricing', 'sort_order' => 4],
                    ['name' => 'Empty Page', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'pages-empty'], 'data_lang' => 'pages-empty', 'sort_order' => 5],
                    ['name' => 'Timeline', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'pages-timeline'], 'data_lang' => 'pages-timeline', 'sort_order' => 6],
                    ['name' => 'Gallery', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'pages-gallery'], 'data_lang' => 'pages-gallery', 'sort_order' => 7],
                    ['name' => 'Sitemap', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'pages-sitemap'], 'data_lang' => 'pages-sitemap', 'sort_order' => 8],
                    ['name' => 'Search Results', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'pages-search-results'], 'data_lang' => 'pages-search-results', 'sort_order' => 9],
                    ['name' => 'Coming Soon', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'pages-coming-soon'], 'data_lang' => 'pages-coming-soon', 'sort_order' => 10],
                    ['name' => 'Privacy Policy', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'pages-privacy-policy'], 'data_lang' => 'pages-privacy-policy', 'sort_order' => 11],
                    ['name' => 'Terms & Conditions', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'pages-terms-conditions'], 'data_lang' => 'pages-terms-conditions', 'sort_order' => 12],
                ],
            ],
            [
                'name' => 'Plugins',
                'type' => 'item',
                'icon' => 'ti ti-cpu',
                'data_lang' => 'plugins',
                'sort_order' => 402,
                'children' => [
                    ['name' => 'Sortable List', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-sortable'], 'data_lang' => 'plugins-sortable', 'sort_order' => 1],
                    ['name' => 'Text Diff', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-text-diff'], 'data_lang' => 'plugins-text-diff', 'sort_order' => 2],
                    ['name' => 'PDF Viewer', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-pdf-viewer'], 'data_lang' => 'plugins-pdf-viewer', 'sort_order' => 3],
                    ['name' => 'i18 Support', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-i18'], 'data_lang' => 'plugins-i18', 'sort_order' => 4],
                    ['name' => 'Sweet Alerts', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-sweet-alerts'], 'data_lang' => 'plugins-sweet-alerts', 'sort_order' => 5],
                    ['name' => 'Idle Timer', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-idle-timer'], 'data_lang' => 'plugins-idle-timer', 'sort_order' => 6],
                    ['name' => 'Password Meter', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-pass-meter'], 'data_lang' => 'plugins-pass-meter', 'sort_order' => 7],
                    ['name' => 'Live Favicon', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-live-favicon'], 'data_lang' => 'plugins-live-favicon', 'sort_order' => 8],
                    ['name' => 'Clipboard', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-clipboard'], 'data_lang' => 'plugins-clipboard', 'sort_order' => 9],
                    ['name' => 'Tree View', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-tree-view'], 'data_lang' => 'plugins-tree-view', 'sort_order' => 10],
                    ['name' => 'Loading Buttons', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-loading-buttons'], 'data_lang' => 'plugins-loading-buttons', 'sort_order' => 11],
                    ['name' => 'Masonry', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-masonry'], 'data_lang' => 'plugins-masonry', 'sort_order' => 12],
                    ['name' => 'Tour', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-tour'], 'data_lang' => 'plugins-tour', 'sort_order' => 13],
                    ['name' => 'Animation', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-animation'], 'data_lang' => 'plugins-animation', 'sort_order' => 14],
                    ['name' => 'Video Player', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'plugins-video-player'], 'data_lang' => 'plugins-video-player', 'sort_order' => 15],
                ],
            ],
            [
                'name' => 'Authentication',
                'type' => 'item',
                'icon' => 'ti ti-password-user',
                'data_lang' => 'authentication',
                'sort_order' => 403,
                'children' => [
                    [
                        'name' => 'Basic',
                        'type' => 'item',
                        'data_lang' => 'auth-basic',
                        'sort_order' => 1,
                        'children' => [
                            ['name' => 'Sign In', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-sign-in'], 'data_lang' => 'auth-sign-in', 'sort_order' => 1],
                            ['name' => 'Sign Up', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-sign-up'], 'data_lang' => 'auth-sign-up', 'sort_order' => 2],
                            ['name' => 'Reset Password', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-reset-pass'], 'data_lang' => 'auth-reset-pass', 'sort_order' => 3],
                            ['name' => 'New Password', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-new-pass'], 'data_lang' => 'auth-new-pass', 'sort_order' => 4],
                            ['name' => 'Two Factor', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-two-factor'], 'data_lang' => 'auth-two-factor', 'sort_order' => 5],
                            ['name' => 'Lock Screen', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-lock-screen'], 'data_lang' => 'auth-lock-screen', 'sort_order' => 6],
                            ['name' => 'Success Mail', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-success-mail'], 'data_lang' => 'auth-success-mail', 'sort_order' => 7],
                            ['name' => 'Login with PIN', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-login-pin'], 'data_lang' => 'auth-login-pin', 'sort_order' => 8],
                            ['name' => 'Delete Account', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-delete-account'], 'data_lang' => 'auth-delete-account', 'sort_order' => 9],
                        ],
                    ],
                    [
                        'name' => 'Card',
                        'type' => 'item',
                        'data_lang' => 'auth-card',
                        'sort_order' => 2,
                        'children' => [
                            ['name' => 'Sign In', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-card-sign-in'], 'data_lang' => 'auth-card-sign-in', 'sort_order' => 1],
                            ['name' => 'Sign Up', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-card-sign-up'], 'data_lang' => 'auth-card-sign-up', 'sort_order' => 2],
                            ['name' => 'Reset Password', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-card-reset-pass'], 'data_lang' => 'auth-card-reset-pass', 'sort_order' => 3],
                            ['name' => 'New Password', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-card-new-pass'], 'data_lang' => 'auth-card-new-pass', 'sort_order' => 4],
                            ['name' => 'Two Factor', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-card-two-factor'], 'data_lang' => 'auth-card-two-factor', 'sort_order' => 5],
                            ['name' => 'Lock Screen', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-card-lock-screen'], 'data_lang' => 'auth-card-lock-screen', 'sort_order' => 6],
                            ['name' => 'Success Mail', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-card-success-mail'], 'data_lang' => 'auth-card-success-mail', 'sort_order' => 7],
                            ['name' => 'Login with PIN', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-card-login-pin'], 'data_lang' => 'auth-card-login-pin', 'sort_order' => 8],
                            ['name' => 'Delete Account', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-card-delete-account'], 'data_lang' => 'auth-card-delete-account', 'sort_order' => 9],
                        ],
                    ],
                    [
                        'name' => 'Split',
                        'type' => 'item',
                        'data_lang' => 'auth-split',
                        'sort_order' => 3,
                        'children' => [
                            ['name' => 'Sign In', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-split-sign-in'], 'data_lang' => 'auth-split-sign-in', 'sort_order' => 1],
                            ['name' => 'Sign Up', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-split-sign-up'], 'data_lang' => 'auth-split-sign-up', 'sort_order' => 2],
                            ['name' => 'Reset Password', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-split-reset-pass'], 'data_lang' => 'auth-split-reset-pass', 'sort_order' => 3],
                            ['name' => 'New Password', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-split-new-pass'], 'data_lang' => 'auth-split-new-pass', 'sort_order' => 4],
                            ['name' => 'Two Factor', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-split-two-factor'], 'data_lang' => 'auth-split-two-factor', 'sort_order' => 5],
                            ['name' => 'Lock Screen', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-split-lock-screen'], 'data_lang' => 'auth-split-lock-screen', 'sort_order' => 6],
                            ['name' => 'Success Mail', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-split-success-mail'], 'data_lang' => 'auth-split-success-mail', 'sort_order' => 7],
                            ['name' => 'Login with PIN', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-split-login-pin'], 'data_lang' => 'auth-split-login-pin', 'sort_order' => 8],
                            ['name' => 'Delete Account', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'auth-split-delete-account'], 'data_lang' => 'auth-split-delete-account', 'sort_order' => 9],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Error Pages',
                'type' => 'item',
                'icon' => 'ti ti-alert-triangle',
                'data_lang' => 'error-pages',
                'sort_order' => 404,
                'children' => [
                    ['name' => '400 Bad Request', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'error-400'], 'data_lang' => 'error-400', 'sort_order' => 1],
                    ['name' => '401 Unauthorized', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'error-401'], 'data_lang' => 'error-401', 'sort_order' => 2],
                    ['name' => '403 Forbidden', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'error-403'], 'data_lang' => 'error-403', 'sort_order' => 3],
                    ['name' => '404 Not Found', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'error-404'], 'data_lang' => 'error-404', 'sort_order' => 4],
                    ['name' => '408 Request Timeout', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'error-408'], 'data_lang' => 'error-408', 'sort_order' => 5],
                    ['name' => '500 Internal Server', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'error-500'], 'data_lang' => 'error-500', 'sort_order' => 6],
                    ['name' => 'Maintenance', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'error-maintenance'], 'data_lang' => 'error-maintenance', 'sort_order' => 7],
                ],
            ],

            // --- LAYOUTS HEADER ---
            [
                'name' => 'Layouts',
                'type' => 'header',
                'data_lang' => 'layouts',
                'sort_order' => 500,
            ],
            [
                'name' => 'Layout Options',
                'type' => 'item',
                'icon' => 'ti ti-layout',
                'data_lang' => 'layout-options',
                'sort_order' => 501,
                'children' => [
                    ['name' => 'Scrollable', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-scrollable'], 'target' => '_blank', 'data_lang' => 'layouts-scrollable', 'sort_order' => 1],
                    ['name' => 'Compact', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-compact'], 'target' => '_blank', 'data_lang' => 'layouts-compact', 'sort_order' => 2],
                    ['name' => 'Boxed', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-boxed'], 'target' => '_blank', 'data_lang' => 'layouts-boxed', 'sort_order' => 3],
                    ['name' => 'Horizontal', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-horizontal'], 'target' => '_blank', 'data_lang' => 'layouts-horizontal', 'sort_order' => 4],
                    ['name' => 'Preloader', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-preloader'], 'target' => '_blank', 'data_lang' => 'layouts-preloader', 'sort_order' => 5],
                ],
            ],
            [
                'name' => 'Sidebars',
                'type' => 'item',
                'icon' => 'ti ti-layout-sidebar-inactive',
                'data_lang' => 'sidebars',
                'sort_order' => 502,
                'children' => [
                    ['name' => 'Light Menu', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-sidebar-light'], 'target' => '_blank', 'data_lang' => 'layouts-sidebar-light', 'sort_order' => 1],
                    ['name' => 'Gradient Menu', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-sidebar-gradient'], 'target' => '_blank', 'data_lang' => 'layouts-sidebar-gradient', 'sort_order' => 2],
                    ['name' => 'Gray Menu', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-sidebar-gray'], 'target' => '_blank', 'data_lang' => 'layouts-sidebar-gray', 'sort_order' => 3],
                    ['name' => 'Image Menu', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-sidebar-image'], 'target' => '_blank', 'data_lang' => 'layouts-sidebar-image', 'sort_order' => 4],
                    ['name' => 'Compact Menu', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-sidebar-compact'], 'target' => '_blank', 'data_lang' => 'layouts-sidebar-compact', 'sort_order' => 5],
                    ['name' => 'On Hover Menu', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-sidebar-on-hover'], 'target' => '_blank', 'data_lang' => 'layouts-sidebar-on-hover', 'sort_order' => 6],
                    ['name' => 'On Hover Active', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-sidebar-on-hover-active'], 'target' => '_blank', 'data_lang' => 'layouts-sidebar-on-hover-active', 'sort_order' => 7],
                    ['name' => 'Offcanvas Menu', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-sidebar-offcanvas'], 'target' => '_blank', 'data_lang' => 'layouts-sidebar-offcanvas', 'sort_order' => 8],
                    ['name' => 'No Icons with Lines', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-sidebar-no-icons'], 'target' => '_blank', 'data_lang' => 'layouts-sidebar-no-icons', 'sort_order' => 9],
                    ['name' => 'Sidebar with Lines', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-sidebar-with-lines'], 'target' => '_blank', 'data_lang' => 'layouts-sidebar-with-lines', 'sort_order' => 10],
                ],
            ],
            [
                'name' => 'Topbar',
                'type' => 'item',
                'icon' => 'ti ti-layout-bottombar',
                'data_lang' => 'topbar',
                'sort_order' => 503,
                'children' => [
                    ['name' => 'Dark Topbar', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-topbar-dark'], 'target' => '_blank', 'data_lang' => 'layouts-topbar-dark', 'sort_order' => 1],
                    ['name' => 'Gray Topbar', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-topbar-gray'], 'target' => '_blank', 'data_lang' => 'layouts-topbar-gray', 'sort_order' => 2],
                    ['name' => 'Gradient Topbar', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'layouts-topbar-gradient'], 'target' => '_blank', 'data_lang' => 'layouts-topbar-gradient', 'sort_order' => 3],
                ],
            ],

            // --- COMPONENTS HEADER ---
            [
                'name' => 'Components',
                'type' => 'header',
                'data_lang' => 'components',
                'sort_order' => 600,
            ],
            [
                'name' => 'Base UI',
                'type' => 'item',
                'icon' => 'ti ti-components',
                'data_lang' => 'base-ui',
                'sort_order' => 601,
                'children' => [
                    ['name' => 'Accordions', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-accordions'], 'data_lang' => 'ui-accordions', 'sort_order' => 1],
                    ['name' => 'Alerts', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-alerts'], 'data_lang' => 'ui-alerts', 'sort_order' => 2],
                    ['name' => 'Images', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-images'], 'data_lang' => 'ui-images', 'sort_order' => 3],
                    ['name' => 'Badges', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-badges'], 'data_lang' => 'ui-badges', 'sort_order' => 4],
                    ['name' => 'Breadcrumb', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-breadcrumb'], 'data_lang' => 'ui-breadcrumb', 'sort_order' => 5],
                    ['name' => 'Buttons', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-buttons'], 'data_lang' => 'ui-buttons', 'sort_order' => 6],
                    ['name' => 'Cards', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-cards'], 'data_lang' => 'ui-cards', 'sort_order' => 7],
                    ['name' => 'Carousel', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-carousel'], 'data_lang' => 'ui-carousel', 'sort_order' => 8],
                    ['name' => 'Collapse', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-collapse'], 'data_lang' => 'ui-collapse', 'sort_order' => 9],
                    ['name' => 'Colors', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-colors'], 'data_lang' => 'ui-colors', 'sort_order' => 10],
                    ['name' => 'Dropdowns', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-dropdowns'], 'data_lang' => 'ui-dropdowns', 'sort_order' => 11],
                    ['name' => 'Videos', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-videos'], 'data_lang' => 'ui-videos', 'sort_order' => 12],
                    ['name' => 'Grid Options', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-grid'], 'data_lang' => 'ui-grid', 'sort_order' => 13],
                    ['name' => 'Links', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-links'], 'data_lang' => 'ui-links', 'sort_order' => 14],
                    ['name' => 'List Group', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-list-group'], 'data_lang' => 'ui-list-group', 'sort_order' => 15],
                    ['name' => 'Modals', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-modals'], 'data_lang' => 'ui-modals', 'sort_order' => 16],
                    ['name' => 'Notifications', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-notifications'], 'data_lang' => 'ui-notifications', 'sort_order' => 17],
                    ['name' => 'Offcanvas', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-offcanvas'], 'data_lang' => 'ui-offcanvas', 'sort_order' => 18],
                    ['name' => 'Placeholders', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-placeholders'], 'data_lang' => 'ui-placeholders', 'sort_order' => 19],
                    ['name' => 'Pagination', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-pagination'], 'data_lang' => 'ui-pagination', 'sort_order' => 20],
                    ['name' => 'Popovers', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-popovers'], 'data_lang' => 'ui-popovers', 'sort_order' => 21],
                    ['name' => 'Progress', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-progress'], 'data_lang' => 'ui-progress', 'sort_order' => 22],
                    ['name' => 'Scrollspy', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-scrollspy'], 'data_lang' => 'ui-scrollspy', 'sort_order' => 23],
                    ['name' => 'Spinners', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-spinners'], 'data_lang' => 'ui-spinners', 'sort_order' => 24],
                    ['name' => 'Tabs', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-tabs'], 'data_lang' => 'ui-tabs', 'sort_order' => 25],
                    ['name' => 'Tooltips', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-tooltips'], 'data_lang' => 'ui-tooltips', 'sort_order' => 26],
                    ['name' => 'Typography', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-typography'], 'data_lang' => 'ui-typography', 'sort_order' => 27],
                    ['name' => 'Utilities', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'ui-utilities'], 'data_lang' => 'ui-utilities', 'sort_order' => 28],
                ],
            ],
            ['name' => 'Widgets', 'type' => 'item', 'icon' => 'ti ti-stack-2', 'route_name' => 'page', 'route_params' => ['page' => 'widgets'], 'data_lang' => 'widgets', 'sort_order' => 602],
            ['name' => 'Metrics', 'type' => 'item', 'icon' => 'ti ti-chart-histogram', 'route_name' => 'page', 'route_params' => ['page' => 'metrics'], 'data_lang' => 'metrics', 'sort_order' => 603],
            [
                'name' => 'Forms',
                'type' => 'item',
                'icon' => 'ti ti-clipboard-list',
                'data_lang' => 'forms',
                'sort_order' => 604,
                'children' => [
                    ['name' => 'Basic Elements', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'form-elements'], 'data_lang' => 'form-elements', 'sort_order' => 1],
                    ['name' => 'Pickers', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'form-pickers'], 'data_lang' => 'form-pickers', 'sort_order' => 2],
                    ['name' => 'Select', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'form-select'], 'data_lang' => 'form-select', 'sort_order' => 3],
                    ['name' => 'Validation', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'form-validation'], 'data_lang' => 'form-validation', 'sort_order' => 4],
                    ['name' => 'Wizard', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'form-wizard'], 'data_lang' => 'form-wizard', 'sort_order' => 5],
                    ['name' => 'File Uploads', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'form-fileuploads'], 'data_lang' => 'form-fileuploads', 'sort_order' => 6],
                    ['name' => 'Text Editors', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'form-text-editors'], 'data_lang' => 'form-text-editors', 'sort_order' => 7],
                    ['name' => 'Range Slider', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'form-range-slider'], 'data_lang' => 'form-range-slider', 'sort_order' => 8],
                    ['name' => 'Layouts', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'form-layout'], 'data_lang' => 'form-layout', 'sort_order' => 9],
                    ['name' => 'Other Plugins', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'form-other-plugin'], 'data_lang' => 'form-other-plugin', 'sort_order' => 10],
                ],
            ],
            [
                'name' => 'Tables',
                'type' => 'item',
                'icon' => 'ti ti-table-column',
                'data_lang' => 'tables',
                'sort_order' => 605,
                'children' => [
                    ['name' => 'Static Tables', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-static'], 'data_lang' => 'tables-static', 'sort_order' => 1],
                    ['name' => 'Custom Tables', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-custom'], 'data_lang' => 'tables-custom', 'sort_order' => 2],
                    [
                        'name' => 'DataTables',
                        'type' => 'item',
                        'badge_text' => '15',
                        'badge_class' => 'badge bg-success text-white float-end',
                        'data_lang' => 'datatables',
                        'sort_order' => 3,
                        'children' => [
                            ['name' => 'Basic', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-basic'], 'data_lang' => 'tables-datatables-basic', 'sort_order' => 1],
                            ['name' => 'Export Data', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-export-data'], 'data_lang' => 'tables-datatables-export-data', 'sort_order' => 2],
                            ['name' => 'Select', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-select'], 'data_lang' => 'tables-datatables-select', 'sort_order' => 3],
                            ['name' => 'Ajax', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-ajax'], 'data_lang' => 'tables-datatables-ajax', 'sort_order' => 4],
                            ['name' => 'Javascript Source', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-javascript'], 'data_lang' => 'tables-datatables-javascript', 'sort_order' => 5],
                            ['name' => 'Data Rendering', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-rendering'], 'data_lang' => 'tables-datatables-rendering', 'sort_order' => 6],
                            ['name' => 'Scroll', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-scroll'], 'data_lang' => 'tables-datatables-scroll', 'sort_order' => 7],
                            ['name' => 'Fixed Columns', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-fixed-columns'], 'data_lang' => 'tables-datatables-fixed-columns', 'sort_order' => 8],
                            ['name' => 'Fixed Header', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-fixed-header'], 'data_lang' => 'tables-datatables-fixed-header', 'sort_order' => 9],
                            ['name' => 'Show & Hide Column', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-columns'], 'data_lang' => 'tables-datatables-columns', 'sort_order' => 10],
                            ['name' => 'Child Rows', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-child-rows'], 'data_lang' => 'tables-datatables-child-rows', 'sort_order' => 11],
                            ['name' => 'Column Searching', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-column-searching'], 'data_lang' => 'tables-datatables-column-searching', 'sort_order' => 12],
                            ['name' => 'Range Search', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-range-search'], 'data_lang' => 'tables-datatables-range-search', 'sort_order' => 13],
                            ['name' => 'Add Rows', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-rows-add'], 'data_lang' => 'tables-datatables-rows-add', 'sort_order' => 14],
                            ['name' => 'Checkbox Select', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'tables-datatables-checkbox-select'], 'data_lang' => 'tables-datatables-checkbox-select', 'sort_order' => 15],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Icons',
                'type' => 'item',
                'icon' => 'ti ti-icons',
                'data_lang' => 'icons',
                'sort_order' => 606,
                'children' => [
                    ['name' => 'Tabler', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'icons-tabler'], 'data_lang' => 'icons-tabler', 'sort_order' => 1],
                    ['name' => 'Lucide', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'icons-lucide'], 'data_lang' => 'icons-lucide', 'sort_order' => 2],
                    ['name' => 'Flags', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'icons-flags'], 'data_lang' => 'icons-flags', 'sort_order' => 3],
                ],
            ],
            [
                'name' => 'Maps',
                'type' => 'item',
                'icon' => 'ti ti-map',
                'data_lang' => 'maps',
                'sort_order' => 607,
                'children' => [
                    ['name' => 'Google Maps', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'maps-google'], 'data_lang' => 'maps-google', 'sort_order' => 1],
                    ['name' => 'Vector Maps', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'maps-vector'], 'data_lang' => 'maps-vector', 'sort_order' => 2],
                    ['name' => 'Leaflet Maps', 'type' => 'item', 'route_name' => 'page', 'route_params' => ['page' => 'maps-leaflet'], 'data_lang' => 'maps-leaflet', 'sort_order' => 3],
                ],
            ],

            // --- MENU ITEMS HEADER & SPECIAL MENU ---
            [
                'name' => 'Menu Items',
                'type' => 'header',
                'data_lang' => 'menu-items',
                'sort_order' => 700,
            ],
            [
                'name' => 'Menu Levels',
                'type' => 'item',
                'icon' => 'ti ti-sitemap',
                'data_lang' => 'menu-levels',
                'sort_order' => 701,
                'children' => [
                    [
                        'name' => 'Second Level',
                        'type' => 'item',
                        'data_lang' => 'second-level',
                        'sort_order' => 1,
                        'children' => [
                            ['name' => 'Item 2.1', 'type' => 'item', 'url' => '#', 'data_lang' => 'menu-item-1', 'sort_order' => 1],
                            ['name' => 'Item 2.2', 'type' => 'item', 'url' => '#', 'data_lang' => 'menu-item-2', 'sort_order' => 2],
                        ],
                    ],
                    [
                        'name' => 'Second Level',
                        'type' => 'item',
                        'data_lang' => 'second-level-2',
                        'sort_order' => 2,
                        'children' => [
                            ['name' => 'Item 2.1', 'type' => 'item', 'url' => '#', 'data_lang' => 'menu-item-3', 'sort_order' => 1],
                            [
                                'name' => 'Item 2.2',
                                'type' => 'item',
                                'data_lang' => 'menu-item-4',
                                'sort_order' => 2,
                                'children' => [
                                    ['name' => 'Item 3.1', 'type' => 'item', 'url' => '#', 'data_lang' => 'menu-item-5', 'sort_order' => 1],
                                    ['name' => 'Item 3.2', 'type' => 'item', 'url' => '#', 'data_lang' => 'menu-item-6', 'sort_order' => 2],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Disabled Menu',
                'type' => 'item',
                'icon' => 'ti ti-ban',
                'url' => '#',
                'link_class' => 'disabled',
                'data_lang' => 'disabled-menu',
                'sort_order' => 702,
            ],
            [
                'name' => 'Special Menu',
                'type' => 'item',
                'icon' => 'ti ti-star',
                'url' => '#',
                'link_class' => 'special-menu',
                'data_lang' => 'special-menu',
                'sort_order' => 703,
            ],
        ];

        $this->saveMenuTree($menuTree, null, [$adminRole]);

        // Call AppMenuSeeder to seed custom application menus
        $this->call(AppMenuSeeder::class);
    }

    /**
     * Recursive function to save menu items and attach Spatie roles.
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

            // Attach roles to menu
            if (!empty($rolesToAssign)) {
                $menu->roles()->sync(collect($rolesToAssign)->pluck('id')->toArray());
            }

            if (!empty($children)) {
                $this->saveMenuTree($children, $menu->id, $rolesToAssign);
            }
        }
    }
}
