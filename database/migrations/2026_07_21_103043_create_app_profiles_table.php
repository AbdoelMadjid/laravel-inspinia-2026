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
        Schema::create('app_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('INSPINIA Laravel 2026');
            $table->text('app_description')->nullable();
            $table->string('app_year')->default('2026');
            $table->string('developer_name')->default('Repalogic');
            $table->string('developer_url')->nullable();
            $table->string('logo_light')->nullable();
            $table->string('logo_dark')->nullable();
            $table->string('logo_sm')->nullable();
            $table->string('favicon')->nullable();
            $table->boolean('allow_registration')->default(true);
            $table->boolean('auto_approve_registration')->default(false);
            $table->string('default_registration_role')->default('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_profiles');
    }
};
