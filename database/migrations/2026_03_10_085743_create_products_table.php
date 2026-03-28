<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // ── Identity ─────────────────────────────────────
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique()->nullable();
            $table->string('vendor')->nullable();
            $table->string('meta_tags')->nullable();
            $table->string('meta_description')->nullable();

            // ── Category ─────────────────────────────────────
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->nullOnDelete();
            $table->foreignId('child_sub_category_id')->nullable()->constrained('child_sub_categories')->nullOnDelete();

            // ── Type & File ───────────────────────────────────
            // digital | physical | license | classified_listing | service
            $table->enum('product_type', [
                'digital',
                'physical',
                'license',
                'classified_listing',
                'service',
            ])->default('digital');

            $table->string('upload_type')->default('file'); // file | url
            $table->string('product_file')->nullable();
            $table->string('product_url')->nullable();

            // ── Content ───────────────────────────────────────
            $table->longText('description');
            $table->longText('return_policy')->nullable();

            // ── Images ────────────────────────────────────────
            $table->string('feature_image')->nullable();
            $table->json('gallery_images')->nullable();

            // ── Variants ──────────────────────────────────────
            $table->json('variants')->nullable();

            // ── Pricing & Stock ───────────────────────────────
            $table->decimal('current_price', 12, 2)->default(0);
            $table->decimal('discount_price', 12, 2)->nullable();
            $table->unsignedInteger('stock')->nullable(); // null = unlimited
            $table->boolean('is_unlimited')->default(false);

            // ── Media & Tags ──────────────────────────────────
            $table->string('youtube_url')->nullable();
            $table->json('tags')->nullable();
            $table->json('feature_tags')->nullable();

            // ── Flags ─────────────────────────────────────────
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_highlighted')->default(false);
            $table->boolean('in_catalog')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
