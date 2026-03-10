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
        Schema::create('child_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('child_sub_name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('sub_category_id');
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(true);
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_sub_categories');
    }
};
