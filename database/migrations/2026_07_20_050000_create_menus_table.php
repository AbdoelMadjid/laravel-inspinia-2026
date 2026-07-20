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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('menus')->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['header', 'item', 'divider'])->default('item');
            $table->string('icon')->nullable();
            $table->string('route_name')->nullable();
            $table->json('route_params')->nullable();
            $table->string('url')->nullable();
            $table->string('target')->default('_self');
            $table->string('link_class')->nullable();
            $table->string('badge_text')->nullable();
            $table->string('badge_class')->nullable();
            $table->string('permission_name')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('data_lang')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
