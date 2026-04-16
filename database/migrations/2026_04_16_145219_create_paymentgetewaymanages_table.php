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
        Schema::create('paymentgetewaymanages', function (Blueprint $table) {
            $table->id();
            $table->string('gateway_name'); // 'bkash', 'shurjopay', etc.
            $table->string('username')->nullable();
            $table->string('app_key')->nullable();
            $table->string('app_secret')->nullable();
            $table->string('base_url')->nullable();
            $table->string('password')->nullable();
            $table->string('prefix')->nullable();
            $table->string('success_url')->nullable();
            $table->string('return_url')->nullable();
            $table->tinyInteger('status')->default(1); // 1=active, 0=inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paymentgetewaymanages');
    }
};
