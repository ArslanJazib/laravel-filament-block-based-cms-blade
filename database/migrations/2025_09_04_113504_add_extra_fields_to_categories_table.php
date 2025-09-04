<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Parent category (for hierarchy)
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('categories')
                  ->nullOnDelete()
                  ->after('id');

            // Featured image for category page
            $table->string('featured_image')->nullable()->after('description');

            // Meta/SEO fields
            $table->string('meta_title')->nullable()->after('featured_image');
            $table->string('meta_description', 500)->nullable()->after('meta_title');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'featured_image', 'meta_title', 'meta_description']);
        });
    }
};
