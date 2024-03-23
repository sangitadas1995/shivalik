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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('manager_id')->nullable()->after('id');
            $table->integer('designation')->nullable()->after('manager_id');
            $table->integer('func_area_id')->nullable()->after('designation');
            $table->string('mobile')->unique()->after('email');
            $table->string('address')->nullable()->after('mobile');
            $table->integer('country_id')->nullable()->after('address');
            $table->integer('state_id')->nullable()->after('country_id');
            $table->integer('city_id')->nullable()->after('state_id');
            $table->integer('pincode')->nullable()->after('city_id');
            $table->enum('status', ['A', 'I', 'D'])->default('A')->after('pincode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
