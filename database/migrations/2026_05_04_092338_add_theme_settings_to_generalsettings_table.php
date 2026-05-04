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
            $table->string('primary_color')->default('#be0318');
            $table->string('header_color')->default('#ffffff');
            $table->string('footer_color')->default('#ffffff');
            $table->string('header_text_color')->default('#333333');
            $table->string('footer_text_color')->default('#333333');
            $table->string('font_family')->default('Plus Jakarta Sans');
            $table->integer('font_size')->default(14);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generalsettings', function (Blueprint $table) {
            $table->dropColumn([
                'primary_color', 'header_color', 'footer_color', 
                'header_text_color', 'footer_text_color', 
                'font_family', 'font_size'
            ]);
        });
    }
};
