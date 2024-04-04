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
        Schema::create('sub_menu_permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id')->nullable();
            $table->string('display_name')->nullable();
            $table->string('reserve_keyword')->nullable();
            $table->integer('sort_order')->nullable();
            $table->enum('status', ['A', 'I', 'D'])->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_menu_permissions');
    }
};