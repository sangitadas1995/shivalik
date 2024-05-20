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
        Schema::create('po_payment_received_by_vendors', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('purchase_order_id')->nullable();
            $table->unsignedInteger('payment_mode_id')->nullable();
            $table->float('payment_amount', 8, 2)->nullable();
            $table->float('balance', 8, 2)->nullable();
            $table->enum('payment_type', ['credit', 'debit'])->default('debit');
            $table->string('payment_date')->nullable();
            $table->longText('narration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po_payment_received_by_vendors');
    }
};
