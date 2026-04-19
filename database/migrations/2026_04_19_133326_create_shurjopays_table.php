<?php
// database/migrations/xxxx_create_shurjopays_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shurjopays', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('prefix');
            $table->string('success_url');
            $table->string('return_url');
            $table->string('base_url');
            $table->string('password');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shurjopays');
    }
};
