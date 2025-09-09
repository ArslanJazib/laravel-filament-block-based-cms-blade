<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // Add topic_id foreign key
            $table->foreignId('topic_id')
                ->after('course_id')
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // Rollback: drop topic_id
            if (Schema::hasColumn('lessons', 'topic_id')) {
                $table->dropConstrainedForeignId('topic_id');
            }
        });
    }
};