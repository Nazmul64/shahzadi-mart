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
        Schema::table('generalsettings', function (Blueprint $table) {
            $table->string('top_header_bg_color')->nullable()->default('#0B1121');
            $table->string('top_header_text_color')->nullable()->default('#94a3b8');
            $table->string('main_header_bg_color')->nullable()->default('#ffffff');
            $table->string('main_header_text_color')->nullable()->default('#333333');
            $table->string('button_bg_color')->nullable()->default('#be0318');
            $table->string('button_text_color')->nullable()->default('#ffffff');
            $table->tinyInteger('category_slider_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generalsettings', function (Blueprint $table) {
            $table->dropColumn([
                'top_header_bg_color',
                'top_header_text_color',
                'main_header_bg_color',
                'main_header_text_color',
                'button_bg_color',
                'button_text_color',
                'category_slider_status'
            ]);
        });
    }
};
