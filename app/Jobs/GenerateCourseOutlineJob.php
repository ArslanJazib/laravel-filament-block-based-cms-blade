<?php

namespace App\Jobs;

use App\Models\Course;
use App\Services\AI\AiManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateCourseOutlineJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $courseId;
    public array $options;

    public function __construct(int $courseId, array $options = [])
    {
        $this->courseId = $courseId;
        $this->options = $options;
    }

    public function handle(AiManager $manager)
    {
        $course = Course::find($this->courseId);
        if (! $course) {
            return;
        }
        $driver = $manager->driver('text');
        $messages = [
            [ 'role' => 'system', 'content' => 'You are an instructional designer. Output valid JSON only.' ],
            [ 'role' => 'user', 'content' => json_encode([
                'task' => 'Generate course outline',
                'course' => $course->title,
                'industry' => $this->options['industry'] ?? null,
                'audience' => $this->options['audience'] ?? null,
                'duration' => $this->options['duration'] ?? null,
                'outcomes' => $this->options['outcomes'] ?? null,
                'prompt' => $this->options['prompt'] ?? null,
            ]) ],
        ];

        try {
            $resp = $driver->generateText($messages, [ 'response_format' => [ 'type' => 'json_object' ] ]);
            // attempt to extract JSON in different shapes
            $json = $resp['output'][0]['content'][0]['text'] ?? ($resp['choices'][0]['message']['content'] ?? ($resp['content'] ?? '{}'));
            $outline = json_decode((string) $json, true) ?: [];
        } catch (\Throwable $e) {
            $outline = [];
        }

        // Save a draft outline into course metadata (JSON) so instructors can preview and edit
        $course->meta = array_merge($course->meta ?? [], ['ai_outline_draft' => $outline]);
        $course->description = ($course->description ? $course->description . "\n\n" : '') . '[AI Outline Generated]';
        $course->save();
    }
}
