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
        Schema::table('vendor_purchase_orders', function (Blueprint $table) {
            $table->string('po_pdf_invoice')->nullable()->after('vendors_declaration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_purchase_orders', function (Blueprint $table) {
            //
        });
    }
};
