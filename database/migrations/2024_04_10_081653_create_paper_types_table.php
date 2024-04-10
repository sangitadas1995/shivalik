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
        Schema::create('paper_types', function (Blueprint $table) {
            $table->id();
            $table->string('paper_name')->nullable();
            $table->unsignedInteger('paper_category_id')->nullable();
            $table->unsignedInteger('paper_gsm_id')->nullable();
            $table->unsignedInteger('paper_quality_id')->nullable();
            $table->unsignedInteger('paper_color_id')->nullable();
            $table->string('paper_size_name')->nullable();
            $table->unsignedInteger('paper_unit_id')->nullable();
            $table->string('paper_height')->nullable();
            $table->string('paper_width')->nullable();
            $table->enum('status', ['A', 'I', 'D'])->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paper_types');
    }
};
