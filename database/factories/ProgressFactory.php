<?php

namespace Database\Factories;

use App\Models\Progress;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgressFactory extends Factory
{
    protected $model = Progress::class;

    public function definition(): array
    {
        $completed = $this->faker->boolean(70); // 70% chance of completed

        return [
            'student_id' => User::role('user')->inRandomOrder()->first()?->id,
            'lesson_id' => Lesson::factory(),
            'completed' => $completed,
            'completed_at' => $completed ? now()->subDays(rand(1, 10)) : null,
        ];
    }
}
