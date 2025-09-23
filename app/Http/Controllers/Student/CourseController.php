<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\CourseComment;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // List all enrolled courses    
    public function index()
    {
        $courses = auth()->user()
            ->enrolledCourses()
            ->withCount('lessons')
        ->paginate(9);

        return view('frontend.courses.my-courses', compact('courses'));
    }

    // Show enrolled course page (default lesson = first lesson)
    public function show(Course $course)
    {
        $this->authorize('view', $course); // check if user is enrolled

        $currentLesson = $course->topics->flatMap->lessons->first();
        return view('frontend.courses.enrolled', compact('course', 'currentLesson'));
    }

    // Show a specific lesson inside an enrolled course
    public function lesson(Course $course, Lesson $lesson)
    {
        $this->authorize('view', $course);

        return view('frontend.courses.enrolled', [
            'course' => $course,
            'currentLesson' => $lesson,
        ]);
    }

    // Store comment for a lesson
    public function comment(Request $request, Course $course, Lesson $lesson)
    {
        $this->authorize('view', $course);

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        CourseComment::create([
            'user_id' => $request->user()->id,
            'lesson_id' => $lesson->id,
            'content' => $request->comment,
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    // Submit course rating
    public function rate(Request $request, Course $course)
    {
        $this->authorize('view', $course);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $course->ratings()->updateOrCreate(
            ['user_id' => $request->user()->id],
            ['rating' => $request->rating]
        );

        return back()->with('success', 'Rating submitted successfully!');
    }
}