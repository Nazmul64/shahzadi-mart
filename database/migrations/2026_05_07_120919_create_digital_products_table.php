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
        Schema::create('digital_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('child_sub_category_id')->nullable()->constrained()->onDelete('set null');
            $table->text('description');
            $table->string('feature_image')->nullable();
            $table->text('gallery_images')->nullable(); // JSON
            $table->decimal('current_price', 15, 2);
            $table->decimal('discount_price', 15, 2)->nullable();
            $table->string('upload_type')->default('file'); // file or link
            $table->string('product_file')->nullable();
            $table->text('product_url')->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_pinned')->default(false);
            $table->text('meta_tags')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_products');
    }
};
