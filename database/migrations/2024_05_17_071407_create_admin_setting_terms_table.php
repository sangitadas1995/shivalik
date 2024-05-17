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
        Schema::create('admin_setting_terms', function (Blueprint $table) {
            $table->id();
            $table->string('admin_terms_condition')->nullable();
            $table->string('additional_note_settings')->nullable();
            $table->string('po_facilitation_settings')->nullable();
            $table->string('thanks_regards_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_setting_terms');
    }
};
