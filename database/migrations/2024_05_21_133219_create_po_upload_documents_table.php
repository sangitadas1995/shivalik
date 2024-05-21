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
        Schema::create('po_upload_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('purchase_order_id')->nullable();
            $table->unsignedInteger('po_file_type_id')->nullable();
            $table->string('po_file_type_title')->nullable();
            $table->string('po_file')->nullable();
            $table->string('po_file_extension')->nullable();
            $table->enum('status', ['A', 'I', 'D'])->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po_upload_documents');
    }
};
