<?php

namespace App\Http\Controllers\Student;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Progress;
use Illuminate\Http\Request;
use App\Models\CourseComment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * List all enrolled courses for the logged-in student
     */
    public function index()
    {
        $courses = auth()->user()
            ->courses()
            ->withCount('lessons')
            ->paginate(9);

        return view('frontend.courses.my-courses', compact('courses'));
    }

    /**
     * Show a specific lesson inside an enrolled course
     */
    public function lesson(Course $course, Lesson $lesson)
    {
        // Eager load course with relationships
        $course->load([
            'category',
            'instructor',
            'topics.lessons',
            'comments' => fn($q) => $q->latest()->take(5)->with('user'),
            'ratings'  => fn($q) => $q->latest()->take(5)->with('user'),
        ]);

        // If user is logged in and enrolled
        if (auth()->check() && $course->enrollments()->where('student_id', auth()->id())->exists()) {
            $studentId = auth()->id();

            // If a specific lesson is passed, use that
            if ($lesson && $lesson->course_id === $course->id) {
                $currentLesson = $lesson;
            } else {
                // Otherwise: Get most recently accessed *incomplete* lesson
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
                    ->orderBy('lessons.topic_id', 'ASC')  // keep topic order
                    ->orderBy('lessons.order', 'ASC')     // fallback lesson order
                    ->select('lessons.*')
                    ->first();

                // Fallback to first lesson if none found
                if (! $currentLesson) {
                    $currentLesson = $course->lessons()->orderBy('order', 'asc')->first();
                }
            }

            // Fetch progress for that lesson
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
    }

    /**
     * Store comment for a lesson
     */
    public function comment(Request $request, Course $course, Lesson $lesson)
    {
        if (auth()->check() && $course->enrollments()
            ->where('student_id', auth()->id())
            ->exists()) 
        {
            $request->validate([
                'comment' => 'required|string|max:1000',
            ]);

            CourseComment::create([
                'student_id' => $request->user()->id,
                'lesson_id' => $lesson->id,
                'content' => $request->comment,
            ]);

            return back()->with('success', 'Comment added successfully!');
        }

        return redirect()
            ->route('courses.show', $course->slug)
            ->with('error', 'You must be enrolled to comment.');
    }

    /**
     * Submit course rating
     */
    public function rate(Request $request, Course $course)
    {
        if (auth()->check() && $course->enrollments()
            ->where('student_id', auth()->id())
            ->exists()) 
        {
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'feedback' => 'nullable|string|max:1000',
            ]);

            $course->ratings()->updateOrCreate(
                ['student_id' => $request->user()->id],
                [
                    'rating' => $request->rating,
                    'feedback' => $request->feedback ?? null,
                ]
            );

            return back()->with('success', 'Rating submitted successfully!');
        }

        return redirect()
            ->route('courses.show', $course->slug)
            ->with('error', 'You must be enrolled to rate this course.');
    }

    /**
     * Update progress
     */
    public function updateProgress(Request $request, Course $course, Lesson $lesson)
    {
        $student = Auth::user();

        $progress = Progress::firstOrCreate([
            'student_id' => $student->id,
            'lesson_id' => $lesson->id,
        ]);

        // For video lessons: update timestamp + percent
        if ($request->has('current_second') && $request->has('total_seconds')) {
            $progress->updateVideoProgress($request->current_second, $request->total_seconds);
        }

        // For general lessons: update percentage
        if ($request->has('progress_percent')) {
            $progress->updateProgress($request->progress_percent);
        }

        // Mark complete if 100%
        if ($request->progress_percent == 100 || $request->completed) {
            $progress->markAsCompleted();
        }

        return response()->json(['success' => true]);
    }
}