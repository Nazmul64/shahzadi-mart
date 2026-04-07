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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->enum('allow_product_type', ['all', 'category', 'sub_category', 'child_sub_category'])->default('all');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('child_sub_category_id')->nullable();
            $table->enum('type', ['discount_by_percentage', 'discount_by_amount']);
            $table->decimal('percentage', 5, 2)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->enum('quantity', ['unlimited', 'limited'])->default('unlimited');
            $table->integer('quantity_limit')->nullable();
            $table->integer('used')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['activated', 'deactivated'])->default('activated');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('set null');
            $table->foreign('child_sub_category_id')->references('id')->on('child_sub_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
