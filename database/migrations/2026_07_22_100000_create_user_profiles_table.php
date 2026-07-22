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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('motto')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('job_title')->nullable();
            $table->string('education')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->json('languages')->nullable();
            $table->text('about_me')->nullable();
            $table->json('skills')->nullable();
            $table->json('social_links')->nullable();
            $table->json('extra_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
