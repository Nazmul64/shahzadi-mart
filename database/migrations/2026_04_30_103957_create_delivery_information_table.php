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
        Schema::create('delivery_information', function (Blueprint $table) {
            $table->id();

            // Header
            $table->string('header_title')->nullable();

            // Home Delivery
            $table->string('home_delivery_title')->nullable();
            $table->text('home_delivery_description')->nullable();

            // Pickup Facility
            $table->string('pickup_title')->nullable();
            $table->text('pickup_description')->nullable();

            // Instant Download
            $table->string('instant_download_title')->nullable();
            $table->text('instant_download_description')->nullable();

            // Secure Payment
            $table->string('secure_title')->nullable();
            $table->text('secure_description')->nullable();

            // Cash on Delivery
            $table->string('cod_title')->nullable();
            $table->text('cod_description')->nullable();

            // Mobile Banking
            $table->string('mobile_banking_title')->nullable();
            $table->text('mobile_banking_description')->nullable();

            // Footer Company Info
            $table->text('footer_company_information')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_information');
    }
};
