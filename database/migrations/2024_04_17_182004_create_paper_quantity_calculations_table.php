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
        Schema::create('paper_quantity_calculations', function (Blueprint $table) {
            $table->id();
            $table->string('quantity')->nullable(); //1
            $table->string('from_unit')->nullable(); //rim(unit_id = 2)
            $table->string('quantity_description')->nullable(); //20 (long) quires
            $table->string('conversion_ratio')->nullable(); // 500 
            $table->string('conversion_unit')->nullable(); // sheet (5) 
            $table->enum('status', ['A', 'I', 'D'])->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paper_quantity_calculations');
    }
};
