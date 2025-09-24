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
    public function lesson(Course $course, Lesson $lesson = null)
    {
        $student = Auth::user();

        // Ensure student is enrolled
        if (!$course->enrollments()->where('student_id', $student->id)->exists()) {
            return redirect()
                ->route('courses.show', $course->slug)
                ->with('error', 'You must enroll in this course to access lessons.');
        }

        // If no lesson is passed, find the next incomplete lesson
        if (!$lesson) {
            $lesson = $course->lessons()
                ->leftJoin('progresses', function ($join) use ($student) {
                    $join->on('lessons.id', '=', 'progresses.lesson_id')
                        ->where('progresses.student_id', '=', $student->id);
                })
                ->orderByRaw("COALESCE(progresses.progress_percent, 0) ASC") // lowest progress first
                ->orderBy('lessons.position', 'ASC') // fallback order
                ->select('lessons.*')
                ->first();
        }

        // Fetch progress for current lesson
        $progress = $lesson ? $lesson->progress()->where('student_id', $student->id)->first() : null;

        return view('frontend.courses.enrolled', [
            'course' => $course,
            'currentLesson' => $lesson,
            'progress' => $progress,
        ]);
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