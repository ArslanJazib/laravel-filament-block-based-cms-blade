<?php

namespace App\Services\AI\Contracts;

interface AiDriverInterface
{
    /** Generate text from messages (chat-style) */
    public function generateText(array $messages, array $options = []): array;

    /** Generate an image; return provider raw response */
    public function generateImage(string $prompt, ?string $size = null, array $options = []): array;

    /** Generate TTS audio (returns raw response or binary) */
    public function synthesizeSpeech(string $text, array $options = []): array|string;

    /** Trigger video render if supported */
    public function renderVideo(array $payload): array;

    /**
     * Query status of an asynchronous video job. Return provider response or ['error' => 'not_supported']
     */
    public function videoStatus(string $jobId): array;
}
