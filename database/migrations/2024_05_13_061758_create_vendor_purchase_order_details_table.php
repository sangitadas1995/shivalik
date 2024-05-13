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
        Schema::create('vendor_purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('purchase_order_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->string('purchase_price')->nullable();
            $table->string('order_qty')->nullable();
            $table->string('receive_qty')->nullable();
            $table->string('reason')->nullable();
            $table->string('discount')->nullable();
            $table->string('gst')->nullable();
            $table->float('net_amount', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_purchase_order_details');
    }
};
