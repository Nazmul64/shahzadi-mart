<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nagad_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(0);
            $table->string('mode')->default('sandbox');
            $table->string('title')->nullable();
            $table->string('merchant_id')->nullable();
            $table->text('merchant_private_key')->nullable();
            $table->text('nagad_public_key')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nagad_settings');
    }
};
