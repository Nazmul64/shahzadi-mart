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
        Schema::create('seller_admin_chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->enum('sender', ['admin', 'seller']);
            $table->text('message')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            
            // Assuming users table has the sellers
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_admin_chats');
    }
};
