<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableNames = config('permission.table_names');
        $rolesTable = $tableNames['roles'] ?? 'roles';

        Schema::create('menu_role', function (Blueprint $table) use ($rolesTable) {
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->foreignId('role_id')->constrained($rolesTable)->onDelete('cascade');
            $table->primary(['menu_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_role');
    }
};
