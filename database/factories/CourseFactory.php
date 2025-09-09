<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);

        return [
            'category_id' => Category::inRandomOrder()->first(),
            'instructor_id' => User::role('instructor')->inRandomOrder()->first()?->id,
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['draft', 'published']),
            'thumbnail' => $this->faker->imageUrl(640, 480, 'courses', true),
        ];
    }
}
