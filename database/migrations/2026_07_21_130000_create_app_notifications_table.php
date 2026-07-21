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
        Schema::create('app_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('category')->default('system'); // password_reset, message, task, system
            $table->string('title');
            $table->text('message');
            $table->string('url')->nullable();
            $table->string('icon')->nullable()->default('ti ti-bell');
            $table->string('icon_bg')->nullable()->default('bg-primary-subtle text-primary');
            $table->string('target_role')->nullable(); // e.g. 'admin'
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_notifications');
    }
};
