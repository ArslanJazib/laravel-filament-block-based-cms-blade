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
        Schema::create('ai_integrations', function (Blueprint $table) {
            $table->id();
            $table->string('provider');
            $table->string('model');
            $table->string('model_type')->default('text'); // NEW: text, image, video, tts, etc.
            $table->string('display_name')->nullable();
            $table->boolean('is_active')->default(false);
            $table->integer('priority_order')->default(1);
            $table->integer('max_requests_per_day')->default(0);
            $table->integer('max_requests_per_month')->nullable();
            $table->integer('current_request_count')->default(0);
            $table->decimal('estimated_cost_per_request', 10, 5)->default(0);
            $table->decimal('alerts_at', 5, 2)->default(0.8);
            $table->timestamp('last_reset_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_integrations');
    }
};
