<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affiliate_products', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('product_name');
            $table->string('product_sku')->unique();
            $table->string('product_affiliate_link');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('child_category_id')->nullable();
            $table->integer('product_stock')->nullable(); // null = Always Available

            // Optional Toggles
            $table->boolean('allow_measurement')->default(false);
            $table->string('product_measurement')->nullable();   // e.g. None / cm / inch

            $table->boolean('allow_condition')->default(false);
            $table->string('product_condition')->nullable();     // New / Used / Refurbished

            $table->boolean('allow_shipping_time')->default(false);
            $table->string('estimated_shipping_time')->nullable();

            $table->boolean('allow_colors')->default(false);
            $table->string('product_colors')->nullable();        // comma separated or json

            $table->boolean('allow_sizes')->default(false);
            $table->string('product_sizes')->nullable();         // comma separated

            // Content
            $table->longText('product_description');
            $table->longText('buy_return_policy');

            // Feature Image
            $table->string('feature_image_source')->default('file');
            $table->string('feature_image')->nullable();

            // Gallery images stored as JSON array of paths
            $table->json('gallery_images')->nullable();

            // Pricing
            $table->decimal('current_price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();

            // Video
            $table->string('youtube_video_url')->nullable();

            // Feature Tags: [{keyword, color}]
            $table->json('feature_tags')->nullable();

            // Tags
            $table->string('tags')->nullable();

            // SEO
            $table->boolean('allow_seo')->default(false);
            $table->string('meta_tags')->nullable();
            $table->text('meta_description')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliate_products');
    }
};
