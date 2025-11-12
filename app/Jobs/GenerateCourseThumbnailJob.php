<?php

namespace App\Jobs;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateCourseThumbnailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $courseId;
    public array $options;

    public function __construct(int $courseId, array $options = [])
    {
        $this->courseId = $courseId;
        $this->options = $options;
    }

    public function handle(\App\Services\AI\AiManager $manager)
    {
        $course = Course::find($this->courseId);
        if (! $course) {
            return;
        }
        $driver = $manager->driver('image');
        $base = 'Course thumbnail: ' . $course->title . ', category ' . optional($course->category)->name . ', flat minimalist style';
        $prompt = $base . (isset($this->options['prompt']) && $this->options['prompt'] ? "\n\nInstructor notes: " . $this->options['prompt'] : '');

        try {
            $res = $driver->generateImage($prompt, $this->options['size'] ?? null, $this->options);
            $b64 = $res['data'][0]['b64_json'] ?? $res['b64'] ?? null;
            if ($b64) {
                $binary = base64_decode($b64);
                $path = 'tmp/ai-thumb-' . $course->id . '-' . uniqid() . '.png';
                Storage::disk('local')->put($path, $binary);
                $course->addMediaFromDisk($path, 'local')->usingFileName('ai-thumbnail-' . $course->id . '.png')->toMediaCollection('course-thumbnails');
                Storage::disk('local')->delete($path);
            }
        } catch (\Throwable $e) {
            // noop
        }
    }
}
