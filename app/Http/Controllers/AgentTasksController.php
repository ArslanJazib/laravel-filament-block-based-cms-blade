<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Services\AI\AiVideoService;
use App\Jobs\GenerateCourseOutlineJob;
use App\Jobs\GenerateCourseThumbnailJob;
use App\Jobs\GenerateCourseIntroVideoJob;


class AgentTasksController extends Controller
{
    public function generateCourseOutline(Request $request, Course $course)
    {
        if (Gate::denies('update', $course)) {
            abort(403);
        }

        $data = Validator::make($request->all(), [
            'industry' => 'nullable|string|max:120',
            'audience' => 'nullable|string|max:120',
            'duration' => 'nullable|integer|min:1|max:200',
            'outcomes' => 'nullable|string|max:2000',
        ])->validate();

        // Dispatch async job to generate outline (preferred)
        GenerateCourseOutlineJob::dispatch($course->id, $data);
        return response()->json(['status' => 'queued']);
    }

    public function generateCourseThumbnail(Request $request, Course $course)
    {
        if (Gate::denies('update', $course)) {
            abort(403);
        }

        $data = Validator::make($request->all(), [
            'size' => 'nullable|string',
        ])->validate();
        // Queue thumbnail generation
        $options = ['size' => $data['size'] ?? null];
        GenerateCourseThumbnailJob::dispatch($course->id, $options);
        return response()->json(['status' => 'queued']);
    }

    public function generateCourseIntroVideo(Request $request, Course $course)
    {
        if (Gate::denies('update', $course)) {
            abort(403);
        }
        $options = $request->only(['prompt']);
        GenerateCourseIntroVideoJob::dispatch($course->id, $options);
        return response()->json(['status' => 'queued']);
    }
    public function renderLessonVideo(Request $request, Lesson $lesson)
    {
        if (Gate::denies('update', $lesson->course)) {
            abort(403);
        }

        $data = Validator::make($request->all(), [
            'title' => 'nullable|string|max:200',
            'script' => 'nullable|string|max:20000',
            'slides' => 'nullable|array',
        ])->validate();

        $payload = [
            'title' => $data['title'] ?? $lesson->title,
            'script' => $data['script'] ?? (string) $lesson->content,
            'slides' => $data['slides'] ?? [],
            'lesson_id' => $lesson->id,
            'course_id' => $lesson->course_id,
        ];

        $service = app(AiVideoService::class);
        $result = $service->render($payload);

        return response()->json($result);
    }

    public function renderStatus(Request $request)
    {
        $data = Validator::make($request->all(), [
            'job_id' => 'required|string',
        ])->validate();

        $service = app(AiVideoService::class);
        $result = $service->status($data['job_id']);
        return response()->json($result);
    }

    public function enhanceLesson(Request $request, Lesson $lesson)
    {
        if (Gate::denies('update', $lesson->course)) {
            abort(403);
        }
        $driver = app(\App\Services\AI\AiManager::class)->driver('text');
        $messages = [
            [ 'role' => 'system', 'content' => 'Format the lesson content as clean HTML with headings and lists. Return plain text HTML only.' ],
            [ 'role' => 'user', 'content' => (string) $lesson->content ],
        ];
        try {
            $resp = $driver->generateText($messages, [ 'response_format' => [ 'type' => 'text' ] ]);
            $html = $resp['output'][0]['content'][0]['text'] ?? ($resp['choices'][0]['message']['content'] ?? ($resp['content'] ?? ''));
        } catch (\Throwable $e) {
            $html = '';
        }
        $lesson->content = $html ?: $lesson->content;
        if (empty($lesson->duration)) {
            $lesson->duration = 10; // simple default; could compute from tokens length
        }
        $lesson->save();
        return response()->json(['status' => 'ok']);
    }
}


