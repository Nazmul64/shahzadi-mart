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
        Schema::create('fraud_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique();
            $table->string('ip_address')->nullable();
            $table->enum('status', ['real', 'fake', 'none'])->default('none');
            $table->boolean('is_blocked')->default(false);
            $table->timestamp('blocked_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fraud_profiles');
    }
};
