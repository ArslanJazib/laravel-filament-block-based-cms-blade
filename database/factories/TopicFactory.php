<?php

namespace Database\Factories;

use App\Models\Topic;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicFactory extends Factory
{
    protected $model = Topic::class;

    public function definition(): array
    {
        return [
            'course_id'   => Course::factory(),
            'title'       => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'order'       => $this->faker->numberBetween(1, 10),
        ];
    }
}