<?php

use App\Models\Admin\System\Menu;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $parent = Menu::where('name', 'Users Setting')->first();
        $parentId = $parent?->id;

        $menu = Menu::updateOrCreate(
            ['route_name' => 'admin.password-reset-requests.index'],
            [
                'name' => 'Reset Password',
                'type' => 'item',
                'icon' => null,
                'parent_id' => $parentId,
                'is_active' => true,
                'sort_order' => 4,
            ]
        );

        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $menu->roles()->syncWithoutDetaching([$adminRole->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Menu::where('route_name', 'admin.password-reset-requests.index')->delete();
    }
};
