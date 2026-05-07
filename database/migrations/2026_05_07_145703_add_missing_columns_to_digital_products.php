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
            if (!Schema::hasColumn('digital_products', 'short_description')) {
                $table->text('short_description')->nullable()->after('sku');
            }
            if (!Schema::hasColumn('digital_products', 'brand_id')) {
                $table->foreignId('brand_id')->nullable()->after('child_sub_category_id')->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('digital_products', 'buying_price')) {
                $table->decimal('buying_price', 15, 2)->default(0)->after('current_price');
            }
            if (!Schema::hasColumn('digital_products', 'stock_quantity')) {
                $table->integer('stock_quantity')->default(0)->after('discount_price');
            }
            if (!Schema::hasColumn('digital_products', 'additional_thumbnail')) {
                $table->text('additional_thumbnail')->nullable()->after('feature_image');
            }
            if (!Schema::hasColumn('digital_products', 'license_keys')) {
                $table->text('license_keys')->nullable()->after('product_url');
            }
            if (!Schema::hasColumn('digital_products', 'video_type')) {
                $table->string('video_type')->nullable()->after('license_keys');
            }
            if (!Schema::hasColumn('digital_products', 'video_url')) {
                $table->text('video_url')->nullable()->after('video_type');
            }
            if (!Schema::hasColumn('digital_products', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('digital_products', function (Blueprint $table) {
            $table->dropColumn([
                'short_description', 'brand_id', 'buying_price', 
                'stock_quantity', 'additional_thumbnail', 'video_type', 
                'video_url', 'license_keys', 'meta_title'
            ]);
        });
    }
};
