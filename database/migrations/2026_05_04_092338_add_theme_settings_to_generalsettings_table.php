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
            if (!Schema::hasColumn('generalsettings', 'primary_color')) {
                $table->string('primary_color')->default('#be0318');
            }
            if (!Schema::hasColumn('generalsettings', 'header_color')) {
                $table->string('header_color')->default('#ffffff');
            }
            if (!Schema::hasColumn('generalsettings', 'footer_color')) {
                $table->string('footer_color')->default('#ffffff');
            }
            if (!Schema::hasColumn('generalsettings', 'header_text_color')) {
                $table->string('header_text_color')->default('#333333');
            }
            if (!Schema::hasColumn('generalsettings', 'footer_text_color')) {
                $table->string('footer_text_color')->default('#333333');
            }
            if (!Schema::hasColumn('generalsettings', 'font_family')) {
                $table->string('font_family')->default('Plus Jakarta Sans');
            }
            if (!Schema::hasColumn('generalsettings', 'font_size')) {
                $table->integer('font_size')->default(14);
            }
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
