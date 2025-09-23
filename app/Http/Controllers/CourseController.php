<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('category', 'instructor')
            ->where('status', 'published');

        // Filtering
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $courses = $query->paginate(2);

        return view('frontend.courses.index', compact('courses'));
    }

    public function show(string $slug)
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'instructor', 'topics.lessons'])
            ->firstOrFail();

        // If user is logged in and enrolled
        if (auth()->check() && $course->enrollments()
            ->where('student_id', auth()->id())
            ->exists()) 
        {
            // Pick the first lesson as the current lesson
            $currentLesson = $course->topics->flatMap->lessons->first();

            return view('frontend.courses.enrolled', compact('course', 'currentLesson'));
        }

        // Otherwise show public detail page
        return view('frontend.courses.show', compact('course'));
    }
}