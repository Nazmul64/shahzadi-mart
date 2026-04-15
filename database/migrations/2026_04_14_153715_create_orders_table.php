<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('user_id')->nullable()->index();

            // Customer info
            $table->string('customer_name');
            $table->string('phone');
            $table->text('address');
            $table->string('delivery_area');
            $table->text('note')->nullable();

            // Payment
            $table->string('payment_method')->default('cod'); // cod, bkash, shurjopay, uddoktapay, aamarpay
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('transaction_id')->nullable();

            // Status
            $table->string('order_status')->default('pending'); // pending, processing, shipped, delivered, cancelled

            // Pricing
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('delivery_fee', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->string('coupon_code')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
