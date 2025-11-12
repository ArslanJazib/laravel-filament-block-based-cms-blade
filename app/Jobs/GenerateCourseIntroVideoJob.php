<?php

namespace App\Jobs;

use App\Models\Course;
use App\Services\AI\AiVideoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateCourseIntroVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $courseId;
    public array $options;

    public function __construct(int $courseId, array $options = [])
    {
        $this->courseId = $courseId;
        $this->options = $options;
    }

    public function handle(AiVideoService $videoService)
    {
        $course = Course::find($this->courseId);
        if (! $course) {
            return;
        }

        $script = (string) $course->description;
        if (!empty($this->options['prompt'])) {
            $script = $script . "\n\nInstructor notes: " . $this->options['prompt'];
        }

        $payload = [
            'title' => 'Course Intro: ' . $course->title,
            'script' => $script,
            'slides' => [],
            'course_id' => $course->id,
            'options' => $this->options,
        ];

        // use AiManager driver for video if configured
        $manager = app(\App\Services\AI\AiManager::class);
        $driver = $manager->driver('video');
        if (method_exists($driver, 'renderVideo')) {
            $result = $driver->renderVideo($payload);
        } else {
            $result = $videoService->render($payload);
        }

        // Expecting the webhook to return something like ['job_id' => '...', 'video_url' => '...']
        if (!empty($result['video_url'])) {
            // download and attach
            try {
                $contents = file_get_contents($result['video_url']);
                $path = 'tmp/ai-intro-' . $course->id . '-' . uniqid() . '.mp4';
                Storage::disk('local')->put($path, $contents);
                $course->addMediaFromDisk($path, 'local')->usingFileName('ai-intro-' . $course->id . '.mp4')->toMediaCollection('course-videos');
                Storage::disk('local')->delete($path);
            } catch (\Throwable $e) {
                // noop
            }
        }

        // store job metadata
        $course->meta = array_merge($course->meta ?? [], ['ai_intro_job' => $result['job_id'] ?? null]);
        $course->save();
    }
}
