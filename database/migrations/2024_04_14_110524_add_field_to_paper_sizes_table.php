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
        Schema::table('paper_sizes', function (Blueprint $table) {
            $table->string('height')->nullable()->after('name');
            $table->string('width')->nullable()->after('height');
            $table->unsignedInteger('unit_id')->nullable()->after('width');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paper_sizes', function (Blueprint $table) {
            $table->dropColumn('height');
            $table->dropColumn('width');
            $table->dropColumn('unit_id');
        });
    }
};
