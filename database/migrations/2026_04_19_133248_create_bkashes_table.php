<?php
// database/migrations/xxxx_create_bkashes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bkashes', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('app_key');
            $table->string('app_secret');
            $table->string('base_url');
            $table->string('password');
            $table->tinyInteger('status')->default(1); // 1=active, 0=inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bkashes');
    }
};
