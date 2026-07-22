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
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('nik', 20)->nullable()->after('user_id');
            $table->string('birth_place')->nullable()->after('nik');
            $table->date('birth_date')->nullable()->after('birth_place');
            $table->string('gender', 20)->nullable()->after('birth_date');
            $table->string('religion', 30)->nullable()->after('gender');
            $table->string('marital_status', 30)->nullable()->after('religion');
            $table->text('address')->nullable()->after('location');
            $table->string('rt', 10)->nullable()->after('address');
            $table->string('rw', 10)->nullable()->after('rt');
            $table->string('village')->nullable()->after('rw');
            $table->string('district')->nullable()->after('village');
            $table->string('city_regency')->nullable()->after('district');
            $table->string('province')->nullable()->after('city_regency');
            $table->string('postal_code', 10)->nullable()->after('province');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'birth_place',
                'birth_date',
                'gender',
                'religion',
                'marital_status',
                'address',
                'rt',
                'rw',
                'village',
                'district',
                'city_regency',
                'province',
                'postal_code',
            ]);
        });
    }
};
