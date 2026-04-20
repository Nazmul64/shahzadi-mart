<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_for_companies', function (Blueprint $table) {
            $table->id();

            // ── Company Basic Info ─────────────────────────────────────
            $table->string('company_name');
            $table->string('tagline')->nullable();
            $table->text('short_description')->nullable();  // hero section এ দেখাবে
            $table->longText('about_description')->nullable(); // full about section

            // ── Mission / Vision / Values ──────────────────────────────
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->text('values')->nullable();             // JSON বা plain text

            // ── Images ────────────────────────────────────────────────
            $table->string('logo')->nullable();             // uploads/aboutcompany/
            $table->string('banner_image')->nullable();     // uploads/aboutcompany/
            $table->string('about_image')->nullable();      // uploads/aboutcompany/

            // ── Stats / Highlights ─────────────────────────────────────
            $table->string('founded_year')->nullable();
            $table->string('total_employees')->nullable();
            $table->string('total_clients')->nullable();
            $table->string('total_projects')->nullable();

            // ── Contact Info ───────────────────────────────────────────
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();

            // ── Social Links ───────────────────────────────────────────
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedin')->nullable();

            // ── SEO ────────────────────────────────────────────────────
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_for_companies');
    }
};
