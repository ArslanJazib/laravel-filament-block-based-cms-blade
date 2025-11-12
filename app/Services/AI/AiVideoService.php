<?php

namespace App\Services\AI;

use App\Services\AI\AiManager;

class AiVideoService
{
    protected AiManager $manager;

    public function __construct(AiManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Trigger a video render job with lesson/script inputs.
     * Expected payload example: [ 'title' => '...', 'script' => '...', 'slides' => [...], 'voiceover_url' => null ]
     */
    public function render(array $payload): array
    {
        $driver = $this->manager->driver('video');
        if (!method_exists($driver, 'renderVideo')) {
            return ['error' => 'not_supported'];
        }
        return $driver->renderVideo($payload);
    }

    /**
     * Poll job status by ID.
     */
    public function status(string $jobId): array
    {
        $driver = $this->manager->driver('video');
        if (!method_exists($driver, 'videoStatus')) {
            return ['error' => 'not_supported'];
        }
        return $driver->videoStatus($jobId);
    }
}



