// database/migrations/xxxx_create_steadfast_orders_table.php
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
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('consignment_id')->nullable();
            $table->string('invoice')->nullable();
            $table->string('tracking_code')->nullable();
            $table->decimal('cod_amount', 10, 2)->default(0);
            $table->string('status')->default('pending'); // pending, delivered, partial_delivered, cancelled, unknown
            $table->decimal('delivery_charge', 10, 2)->default(0);
            $table->string('tracking_message')->nullable();
            $table->string('response_message')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('steadfast_orders');
    }
};
