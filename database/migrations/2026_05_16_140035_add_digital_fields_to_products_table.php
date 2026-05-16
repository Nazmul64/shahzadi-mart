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
        Schema::table('products', function (Blueprint $table) {
            $table->text('short_description')->after('slug')->nullable();
            $table->decimal('buying_price', 15, 2)->after('current_price')->default(0);
            $table->json('license_keys')->after('product_url')->nullable();
            $table->string('video_type')->after('youtube_url')->nullable(); // youtube, file
            $table->string('video_file')->after('video_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['short_description', 'buying_price', 'license_keys', 'video_type', 'video_file']);
        });
    }
};
