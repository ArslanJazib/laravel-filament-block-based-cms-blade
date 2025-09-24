<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
    public function store(Course $course, Request $request)
    {
        $user = $request->user();

        // Check if already enrolled
        if ($course->enrollments()->where('student_id', $user->id)->exists()) {
            return redirect()->route('courses.show', $course->slug)
                ->with('info', 'You are already enrolled in this course.');
        }

        // Enroll user
        Enrollment::create([
            'student_id' => $user->id,
            'course_id' => $course->id,
        ]);

        return redirect()->route('courses.show', $course->slug)
            ->with('success', 'Successfully enrolled! Start learning now.');
    }
}