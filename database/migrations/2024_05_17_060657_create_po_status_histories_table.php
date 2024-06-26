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
        Schema::create('po_status_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('purchase_order_id')->nullable();
            $table->string('purchase_order_status')->nullable();
            $table->string('status_change_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po_status_histories');
    }
};
