<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incomplete_orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->string('phone', 20);          // phone আসলেই insert হয়
            $table->text('address')->nullable();
            $table->string('delivery_area')->nullable();
            $table->string('note')->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('subtotal',   10, 2)->default(0);
            $table->decimal('discount',   10, 2)->default(0);
            $table->decimal('delivery_fee',10,2)->default(0);
            $table->decimal('total',      10, 2)->default(0);
            $table->string('coupon_code')->nullable();
            $table->json('cart_snapshot')->nullable(); // কার্টের snapshot
            $table->string('session_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('page_url')->nullable();
            $table->string('status')->default('incomplete'); // incomplete | recovered
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();

            $table->index('phone');
            $table->index('status');
            $table->index('session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incomplete_orders');
    }
};
