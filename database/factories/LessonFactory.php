<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraphs(3, true),
            'video_url' => $this->faker->optional()->url(),
            'resource_file' => null, // Can attach later if needed
            'order' => $this->faker->numberBetween(1, 20),
        ];
    }
}
