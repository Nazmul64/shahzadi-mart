<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('pathao_orders', function (Blueprint $table) {
            $table->id();

            // order_id nullable — incomplete order এ order_id নাও থাকতে পারে
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('cascade');

            // incomplete_order_id — incomplete order এর জন্য
            $table->unsignedBigInteger('incomplete_order_id')->nullable();
            $table->foreign('incomplete_order_id')
                  ->references('id')
                  ->on('incomplete_orders')
                  ->onDelete('cascade');

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
            $table->longText('response_data')->nullable(); // longText — JSON বড় হতে পারে

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pathao_orders');
    }
};
