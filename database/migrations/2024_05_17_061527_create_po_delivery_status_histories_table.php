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
        Schema::create('po_delivery_status_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('purchase_order_id')->nullable();
            $table->string('purchase_order_delivery_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po_delivery_status_histories');
    }
};
