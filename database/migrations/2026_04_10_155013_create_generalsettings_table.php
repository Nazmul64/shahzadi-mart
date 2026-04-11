<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('generalsettings', function (Blueprint $table) {
            $table->id();
            $table->string('header_logo')->nullable();
            $table->string('footer_logo')->nullable();
            $table->string('invoice_logo')->nullable();
            $table->string('site_name')->default('Genius Shop');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generalsettings');
    }
};
