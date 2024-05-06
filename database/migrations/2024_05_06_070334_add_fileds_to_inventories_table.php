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
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('opening_stock');
            $table->dropColumn('manual_stockin_quantity');
            $table->dropColumn('delevery_date');
            $table->unsignedInteger('quantity')->nullable()->after('warehouse_id');
            $table->string('received_date')->nullable()->after('orderd_date');
            $table->string('vendor_id')->nullable()->after('file');
            $table->longText('narration')->nullable()->after('vendor_id');
            $table->enum('inventory_type', ['opening', 'manual'])->default('opening')->after('narration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            //
        });
    }
};
