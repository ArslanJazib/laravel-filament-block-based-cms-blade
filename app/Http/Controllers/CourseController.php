<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Progress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            ->with([
                'category',
                'instructor',
                'topics.lessons',
                'comments' => fn($q) => $q->latest()->take(5)->with('user'),
                'ratings'  => fn($q) => $q->latest()->take(5)->with('user'),
            ])
            ->firstOrFail();

        // If user is logged in and enrolled
        if (auth()->check() && $course->enrollments()
            ->where('student_id', auth()->id())
            ->exists()) 
        {
            $studentId = auth()->id();

            // Step 1: Get most recently accessed *incomplete* lesson
            $currentLesson = Lesson::where('course_id', $course->id)
                ->leftJoin('progress as p', function ($join) use ($studentId) {
                    $join->on('lessons.id', '=', 'p.lesson_id')
                        ->where('p.student_id', '=', $studentId);
                })
                ->where(function ($q) {
                    $q->whereNull('p.completed')
                    ->orWhere('p.completed', false)
                    ->orWhere('p.progress_percent', '<', 100);
                })
                ->orderByDesc('p.last_accessed_at') // last played
                ->orderBy('lessons.topic_id', 'ASC')  // ensure topics order
                ->orderBy('lessons.order', 'ASC')     // fallback to lesson order
                ->select('lessons.*')
            ->first();

            // Step 2: If none found (no progress yet OR all completed), fallback to first lesson
            if (! $currentLesson) {
                $currentLesson = $course->lessons()->orderBy('order', 'asc')->first();
            }

            // Step 3: Also fetch progress for that lesson
            $progress = $currentLesson
                ? Progress::where('student_id', $studentId)
                    ->where('lesson_id', $currentLesson->id)
                ->first()
            : null;

            // Get recent comments & ratings (already eager loaded)
            $recentComments = $course->comments;
            $recentRatings  = $course->ratings;

            return view('frontend.courses.enrolled', compact(
                'course',
                'progress',
                'currentLesson',
                'recentComments',
                'recentRatings'
            ));
        }

        // Otherwise show public detail page (with recent feedback as well)
        $recentComments = $course->comments;
        $recentRatings  = $course->ratings;

        return view('frontend.courses.show', compact(
            'course',
            'recentComments',
            'recentRatings'
        ));
    }
}