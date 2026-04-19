<?php
// database/migrations/xxxx_create_pathao_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pathao_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('consignment_id')->nullable();
            $table->string('merchant_order_id')->nullable();
            $table->string('order_status')->nullable();
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->integer('store_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('zone_id')->nullable();
            $table->integer('area_id')->nullable();
            $table->decimal('amount_to_collect', 10, 2)->default(0);
            $table->boolean('is_sent')->default(false);
            $table->text('response_data')->nullable(); // full API response
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pathao_orders');
    }
};
