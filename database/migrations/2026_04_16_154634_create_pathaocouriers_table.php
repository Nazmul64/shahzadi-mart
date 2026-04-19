<?php
// database/migrations/xxxx_create_pathaocouriers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pathaocouriers', function (Blueprint $table) {
            $table->id();
            $table->string('base_url')->default('https://courier-api-sandbox.pathao.com');
            $table->string('client_id');
            $table->text('client_secret');
            $table->string('username');
            $table->string('password');
            $table->string('grant_type')->default('password');
            $table->text('access_token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pathaocouriers');
    }
};
