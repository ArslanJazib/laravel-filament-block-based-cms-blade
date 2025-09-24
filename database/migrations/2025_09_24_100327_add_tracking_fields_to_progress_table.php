<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('progress', function (Blueprint $table) {
            // General progress percentage (0–100)
            $table->unsignedTinyInteger('progress_percent')->default(0)->after('completed_at');

            // For video/audio lessons
            $table->integer('current_second')->nullable()->after('progress_percent');
            $table->integer('total_seconds')->nullable()->after('current_second');

            // Last time student engaged with this lesson
            $table->timestamp('last_accessed_at')->nullable()->after('total_seconds');
        });
    }

    public function down(): void
    {
        Schema::table('progress', function (Blueprint $table) {
            $table->dropColumn(['progress_percent', 'current_second', 'total_seconds', 'last_accessed_at']);
        });
    }
};
