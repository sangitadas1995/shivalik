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
        Schema::create('vendor_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_order_no')->nullable();
            $table->string('purchase_order_date')->nullable();
            $table->string('exp_delivery_date')->nullable();
            $table->enum('delivery_status', ['not_received', 'partial_received', 'received'])->default('not_received');
            $table->string('vendor_quotation_no')->nullable();
            $table->string('vendor_quotation_date')->nullable();
            $table->longText('order_by')->nullable();
            $table->unsignedInteger('vendor_id')->nullable();
            $table->longText('vendor_order_details')->nullable();
            $table->unsignedInteger('warehouse_ship_id')->nullable();
            $table->longText('warehouse_ship_details')->nullable();
            $table->float('total_amount', 8, 2)->nullable();
            $table->longText('vendor_bank_details')->nullable();
            $table->unsignedInteger('po_payment_terms')->nullable();
            $table->string('po_payment_credit_days')->nullable();
            $table->longText('terms_conditions')->nullable();
            $table->longText('additional_note')->nullable();
            $table->longText('po_facilitation')->nullable();
            $table->longText('thanksyou_notes')->nullable();
            $table->enum('po_status', ['active', 'completed', 'cancelled'])->default('active');
            $table->longText('po_status_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_purchase_orders');
    }
};
