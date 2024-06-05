<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            if (Schema::hasColumn('inventories', 'stockin_date')) {
                $table->dropColumn('stockin_date');
            }
            $table->dropColumn('purchase_order_no');
            $table->dropColumn('purchase_order_date');
            $table->dropColumn('purchase_order_amount');
            $table->dropColumn('ordered_by');
            $table->dropColumn('orderd_date');
            $table->dropColumn('received_date');
            $table->dropColumn('file');
            $table->dropColumn('vendor_id');
            $table->dropColumn('narration');
            $table->renameColumn('quantity', 'opening_stock');
            $table->renameColumn('low_atock', 'low_stock');
            DB::statement("ALTER TABLE `inventories` CHANGE `inventory_type` `inventory_type` ENUM('opening', 'manual', 'automatic') NOT NULL DEFAULT 'opening';");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('stockin_date');
            $table->dropColumn('purchase_order_no');
            $table->dropColumn('purchase_order_date');
            $table->dropColumn('purchase_order_amount');
            $table->dropColumn('ordered_by');
            $table->dropColumn('orderd_date');
            $table->dropColumn('received_date');
            $table->dropColumn('file');
            $table->dropColumn('vendor_id');
            $table->dropColumn('narration');
            $table->renameColumn('opening_stock', 'quantity');
            $table->renameColumn('low_stock', 'low_atock');
        });
    }
};
