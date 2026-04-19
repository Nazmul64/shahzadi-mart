<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producreviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->tinyInteger('rating')->unsigned()->default(5); // 1-5 stars
            $table->text('review')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            // একজন ইউজার একটা প্রোডাক্টে একবারই রিভিউ দিতে পারবে
            $table->unique(['user_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producreviews');
    }
};
