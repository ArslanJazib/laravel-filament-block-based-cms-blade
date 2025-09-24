<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('course_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('rating'); // 1–5
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'course_id']); // prevent duplicate ratings
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_ratings');
    }
};
