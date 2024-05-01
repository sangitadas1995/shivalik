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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('papertype_id')->nullable();
            $table->unsignedInteger('warehouse_id')->nullable();
            $table->unsignedInteger('opening_stock')->nullable();
            $table->unsignedInteger('current_stock')->nullable();
            $table->unsignedInteger('measurement_unit_id')->nullable();
            $table->unsignedInteger('low_atock')->nullable();
            $table->string('stockin_date')->nullable();
            $table->unsignedInteger('manual_stockin_quantity')->nullable();
            $table->string('purchase_order_no')->nullable();
            $table->string('purchase_order_date')->nullable();
            $table->string('purchase_order_amount')->nullable();
            $table->string('ordered_by')->nullable();
            $table->string('orderd_date')->nullable();
            $table->string('delevery_date')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
