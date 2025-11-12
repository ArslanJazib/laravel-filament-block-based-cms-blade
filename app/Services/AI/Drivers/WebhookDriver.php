<?php

namespace App\Services\AI\Drivers;

use App\Services\AI\Contracts\AiDriverInterface;
use App\Services\AI\Clients\WebhookClient;

class WebhookDriver implements AiDriverInterface
{
    protected WebhookClient $client;
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->client = new WebhookClient($config['base_url'] ?? '', $config['auth_header'] ?? null);
    }

    public function generateText(array $messages, array $options = []): array
    {
        $path = $this->config['endpoints']['text'] ?? ($this->config['endpoints']['outline'] ?? '/');
        return $this->client->postJson($path, [ 'messages' => $messages, 'options' => $options ]);
    }

    public function generateImage(string $prompt, ?string $size = null, array $options = []): array
    {
        $path = $this->config['endpoint'] ?? ($this->config['endpoints']['generate'] ?? '/');
        return $this->client->postJson($path, [ 'prompt' => $prompt, 'size' => $size, 'options' => $options ]);
    }

    public function synthesizeSpeech(string $text, array $options = []): array|string
    {
        $path = $this->config['endpoints']['tts'] ?? ($this->config['endpoint'] ?? '/');
        return $this->client->postJson($path, ['text' => $text, 'options' => $options]);
    }

    public function renderVideo(array $payload): array
    {
        $path = $this->config['endpoint'] ?? ($this->config['endpoints']['render'] ?? '/');
        return $this->client->postJson($path, $payload);
    }

    public function videoStatus(string $jobId): array
    {
        $statusPath = $this->config['status_endpoint'] ?? ($this->config['endpoints']['status'] ?? null);
        if (!$statusPath) {
            // fallback to render endpoint + '/status'
            $statusPath = rtrim($this->config['endpoint'] ?? ($this->config['endpoints']['render'] ?? '/'), '/') . '/status';
        }
        return $this->client->postJson($statusPath, ['job_id' => $jobId]);
    }
}
