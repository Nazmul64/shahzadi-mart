<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('steadfast_orders', function (Blueprint $table) {
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
            $table->string('invoice')->nullable();
            $table->string('tracking_code')->nullable();
            $table->string('tracking_link')->nullable();
            $table->decimal('cod_amount', 10, 2)->default(0);
            $table->string('status')->default('pending');
            $table->decimal('delivery_charge', 10, 2)->default(0);
            $table->string('tracking_message')->nullable();
            $table->longText('response_message')->nullable();
            $table->boolean('is_sent')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('steadfast_orders');
    }
};
