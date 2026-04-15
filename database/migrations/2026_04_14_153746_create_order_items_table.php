<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->string('product_name');
            $table->string('product_image')->nullable();
            $table->string('product_slug')->nullable();
            $table->decimal('price', 12, 2);          // unit price at time of order
            $table->decimal('original_price', 12, 2); // before discount
            $table->unsignedInteger('quantity');
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
