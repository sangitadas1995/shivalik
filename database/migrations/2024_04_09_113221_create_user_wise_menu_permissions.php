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
        Schema::create('user_wise_menu_permissions', function (Blueprint $table){
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('menu_id')->nullable();
            $table->json('sub_menu_ids')->nullable();
            $table->enum('status', ['A', 'I', 'D'])->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_wise_menu_permissions');
    }
};
