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
        Schema::table('paper_quantity_calculations', function (Blueprint $table) {
            $table->dropColumn('quantity_unit_name');
            $table->dropColumn('field');
            $table->dropColumn('quantity');
            $table->dropColumn('from_unit');
            $table->dropColumn('quantity_description');
            $table->dropColumn('conversion_ratio');
            $table->dropColumn('conversion_unit');
            $table->string('packaging_title')->after('id');
            $table->integer('measurement_type_unit', )->after('packaging_title');
            $table->integer('no_of_sheet')->after('measurement_type_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paper_quantity_calculations', function (Blueprint $table) {
            $table->dropColumn('quantity_unit_name');
            $table->dropColumn('field');
            $table->dropColumn('quantity');
            $table->dropColumn('from_unit');
            $table->dropColumn('quantity_description');
            $table->dropColumn('conversion_ratio');
            $table->dropColumn('conversion_unit');
            $table->dropColumn('packaging_title');
            $table->dropColumn('measurement_type_unit');
            $table->dropColumn('no_of_sheet');
            
        });
    }
};
