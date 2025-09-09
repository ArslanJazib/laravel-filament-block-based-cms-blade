<?php

namespace Database\Factories;

use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition(): array
    {
        return [
            'student_id' => User::role('user')->inRandomOrder()->first()?->id,
            'course_id' => Course::factory(),
            'enrolled_at' => now()->subDays(rand(1, 30)),
        ];
    }
}
