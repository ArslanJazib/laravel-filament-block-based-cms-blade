<?php

namespace App\Services\AI\Drivers;

use App\Services\AI\Contracts\AiDriverInterface;
use App\Services\AI\Clients\OpenAiClient;

class OpenAiDriver implements AiDriverInterface
{
    protected OpenAiClient $client;

    public function __construct(array $config)
    {
        $this->client = new OpenAiClient($config['base_url'] ?? '', $config['api_key'] ?? '');
    }

    public function generateText(array $messages, array $options = []): array
    {
        $model = $options['model'] ?? ($options['models']['draft'] ?? 'gpt-4o-mini');
        return $this->client->responsesFromMessages($messages, $model, $options);
    }

    public function generateImage(string $prompt, ?string $size = null, array $options = []): array
    {
        $model = $options['model'] ?? ($options['model'] ?? 'gpt-image-1');
        return $this->client->imagesGenerate($model, $prompt, $size ?? ($options['size'] ?? '1024x1024'));
    }

    public function synthesizeSpeech(string $text, array $options = []): array|string
    {
        $model = $options['model'] ?? ($options['model'] ?? 'tts-1');
        return $this->client->tts($model, $options['voice'] ?? 'alloy', $text, $options['format'] ?? 'mp3');
    }

    public function renderVideo(array $payload): array
    {
        // OpenAI doesn't provide video render through this client; return not supported
        return ['error' => 'not_supported'];
    }

    public function videoStatus(string $jobId): array
    {
        return ['error' => 'not_supported'];
    }
}
