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
        Schema::table('inventory_details', function (Blueprint $table) {
            $table->string('stockin_date')->nullable()->after('stock_type');
            $table->string('purchase_order_no')->nullable()->after('stockin_date');
            $table->string('purchase_order_date')->nullable()->after('purchase_order_no');
            $table->string('purchase_order_amount')->nullable()->after('purchase_order_date');
            $table->string('ordered_by')->nullable()->after('purchase_order_amount');
            $table->string('orderd_date')->nullable()->after('ordered_by');
            $table->string('received_date')->nullable()->after('orderd_date');
            $table->string('file')->nullable()->after('received_date');
            $table->longText('narration')->nullable()->after('file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_details', function (Blueprint $table) {
            //
        });
    }
};
