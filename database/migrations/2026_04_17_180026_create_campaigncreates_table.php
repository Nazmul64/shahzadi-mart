<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigncreates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('media_type')->default('Image'); // 'Image' or 'Video'
            $table->string('image')->nullable();
            $table->string('image_two')->nullable();
            $table->string('image_three')->nullable();
            $table->string('video')->nullable();       // uploaded video file path
            $table->string('video_url')->nullable();   // video URL (YouTube/etc)
            $table->text('review')->nullable();
            $table->string('review_image')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigncreates');
    }
};
