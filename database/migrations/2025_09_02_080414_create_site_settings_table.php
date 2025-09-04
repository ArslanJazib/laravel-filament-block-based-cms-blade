<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->default('My Site');
            $table->string('favicon')->nullable();
            $table->string('favicon_16x16')->nullable();
            $table->string('favicon_32x32')->nullable();
            $table->string('logo')->nullable();
            $table->string('apple_touch_icon')->nullable();
            $table->string('android_chrome_512x512')->nullable();
            $table->string('android_chrome_192x192')->nullable();
            $table->text('google_tag_manager')->nullable();
            $table->json('header_menu')->nullable();
            $table->json('footer_menu')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};