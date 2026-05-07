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
        Schema::table('digital_products', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('slug')->nullable()->change();
            $table->foreignId('category_id')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->decimal('current_price', 15, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('digital_products', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('slug')->nullable(false)->change();
            $table->foreignId('category_id')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
            $table->decimal('current_price', 15, 2)->nullable(false)->change();
        });
    }
};
