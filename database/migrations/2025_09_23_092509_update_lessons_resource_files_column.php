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
        Schema::table('lessons', function (Blueprint $table) {
            $table->json('resource_files')->nullable()->after('video_url');

            // If old column exists, drop it
            if (Schema::hasColumn('lessons', 'resource_file')) {
                $table->dropColumn('resource_file');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('resource_file')->nullable();
            $table->dropColumn('resource_files');
        });
    }
};
