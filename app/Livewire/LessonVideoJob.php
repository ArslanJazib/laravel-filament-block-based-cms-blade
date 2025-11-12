<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\AI\AiVideoService;
use App\Models\Lesson;

class LessonVideoJob extends Component
{
    public string $jobId;
    public int $lessonId;
    public string $status = 'queued';
    public ?int $progress = null;
    public ?string $videoUrl = null;
    public bool $attached = false;

    public function mount(string $jobId, int $lessonId): void
    {
        $this->jobId = $jobId;
        $this->lessonId = $lessonId;
    }

    public function poll(): void
    {
        $service = app(AiVideoService::class);
        $res = $service->status($this->jobId);
        $this->status = (string) ($res['status'] ?? $this->status);
        $this->progress = isset($res['progress']) ? (int) $res['progress'] : $this->progress;
        $url = $res['video_url'] ?? null;
        if ($this->status === 'completed' && $url && !$this->attached) {
            $lesson = Lesson::find($this->lessonId);
            if ($lesson) {
                try {
                    $lesson->addMediaFromUrl($url)->toMediaCollection('lesson-videos');
                    $this->attached = true;
                } catch (\Throwable $e) {
                    // swallow attach errors; show in UI
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.lesson-video-job');
    }
}


