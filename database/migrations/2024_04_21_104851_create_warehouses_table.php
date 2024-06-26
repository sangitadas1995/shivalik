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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('alter_mobile_no')->nullable();
            $table->string('email')->nullable();
            $table->string('alternative_email_id')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('alternative_phone_no')->nullable();
            $table->string('gst')->nullable();
            $table->unsignedInteger('vendor_type_id')->nullable();
            $table->string('address')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->string('pincode')->nullable();
            $table->unsignedInteger('paper_type_id')->nullable();
            $table->unsignedInteger('paper_size_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
