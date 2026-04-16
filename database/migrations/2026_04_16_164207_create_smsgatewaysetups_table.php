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
        Schema::create('smsgatewaysetups', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('api_key');
            $table->string('sender_id');
            $table->boolean('status')->default(1);
            $table->boolean('order_confirm')->default(1);
            $table->boolean('forgot_password')->default(1);
            $table->boolean('password_generator')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smsgatewaysetups');
    }
};
