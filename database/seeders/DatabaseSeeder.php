<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Progress;
use App\Models\PageBlock;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\SiteSettingsSeeder;
use Database\Seeders\CountriesTableSeeder;
use Database\Seeders\CategoriesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SiteSettingsSeeder::class);

        // Create a test page
        $page = Page::factory()->count(1)->create()->first();

        // Attach blocks in proper order
        PageBlock::factory()->heroBanner()->create([
            'page_id'    => $page->id,
            'sort_order' => 1,
        ]);

        PageBlock::factory()->programSection()->create([
            'page_id'    => $page->id,
            'sort_order' => 2,
        ]);

        PageBlock::factory()->studentSignup()->create([
            'page_id'    => $page->id,
            'sort_order' => 3,
        ]);

        $courses = Course::factory()
            ->count(5)
        ->create();

        foreach ($courses as $course) {
            // Create Topics for this course
            for ($t = 1; $t <= 3; $t++) {
                $topic = Topic::factory()->create([
                    'course_id' => $course->id,
                    'order'     => $t,
                ]);

                // Attach Lessons to the topic
                for ($l = 1; $l <= 5; $l++) {
                    Lesson::factory()->create([
                        'course_id' => $course->id,
                        'topic_id' => $topic->id,
                        'order'    => $l,
                    ]);
                }
            }
        }


        $students = User::role('user')->get();
        foreach ($students->take(20) as $student) {
            $course = $courses->random();

            $enrollment = Enrollment::factory()->create([
                'student_id' => $student->id,
                'course_id'  => $course->id,
            ]);

            // progress tied to lessons
            foreach ($course->lessons->random(5) as $lesson) {
                Progress::factory()->create([
                    'student_id' => $student->id,
                    'lesson_id'     => $lesson->id,
                ]);
            }
        }
    }
}
