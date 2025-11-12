<?php

namespace App\Services\AI\Drivers;

use App\Services\AI\Contracts\AiDriverInterface;
use GuzzleHttp\Client;

class GeminiDriver implements AiDriverInterface
{
    protected Client $http;
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->http = new Client(['base_uri' => rtrim($config['base_url'] ?? '', '/') . '/','timeout' => 60]);
    }

    public function generateText(array $messages, array $options = []): array
    {
        $path = $this->config['endpoints']['text'] ?? ($this->config['endpoint'] ?? '/generate');
        $payload = [ 'messages' => $messages, 'options' => $options ];
        $res = $this->http->post(ltrim($path, '/'), [ 'headers' => $this->buildHeaders(), 'json' => $payload ]);
        return json_decode((string) $res->getBody(), true);
    }

    public function generateImage(string $prompt, ?string $size = null, array $options = []): array
    {
        return ['error' => 'not_supported'];
    }

    public function synthesizeSpeech(string $text, array $options = []): array|string
    {
        return ['error' => 'not_supported'];
    }

    public function renderVideo(array $payload): array
    {
        return ['error' => 'not_supported'];
    }

    public function videoStatus(string $jobId): array
    {
        return ['error' => 'not_supported'];
    }

    protected function buildHeaders(): array
    {
        $h = [ 'Content-Type' => 'application/json' ];
        if (!empty($this->config['api_key'])) {
            $h['Authorization'] = 'Bearer ' . $this->config['api_key'];
        }
        return $h;
    }
}
