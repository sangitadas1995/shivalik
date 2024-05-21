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
        Schema::table('po_products_delivery_qty_trackers', function (Blueprint $table) {
            $table->enum('status', ['A', 'I', 'D'])->default('A')->after('delivery_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('po_products_delivery_qty_trackers', function (Blueprint $table) {
            //
        });
    }
};
