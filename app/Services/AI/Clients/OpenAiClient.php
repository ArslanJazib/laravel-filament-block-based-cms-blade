<?php

namespace App\Services\AI\Clients;

use GuzzleHttp\Client;

class OpenAiClient
{
    protected Client $http;
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct(string $baseUrl, string $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
        $this->http = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 60,
        ]);
    }

    public function chat(array $messages, string $model, array $options = []): array
    {
        // Back-compat wrapper: route chat-style messages through the Responses API
        return $this->responsesFromMessages($messages, $model, $options);
    }

    public function responses(array $payload): array
    {
        $res = $this->http->post('responses', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);
        return json_decode((string) $res->getBody(), true);
    }

    public function responsesFromMessages(array $messages, string $model, array $options = []): array
    {
        // Transform chat messages into Responses API input format
        $input = [];
        foreach ($messages as $m) {
            $role = $m['role'] ?? 'user';
            $text = $m['content'] ?? '';
            $input[] = [
                'role' => $role,
                'content' => [ [ 'type' => 'text', 'text' => (string) $text ] ],
            ];
        }

        $payload = [
            'model' => $model,
            'input' => $input,
        ];

        // Map common chat options
        if (isset($options['temperature'])) {
            $payload['temperature'] = $options['temperature'];
        }
        if (isset($options['max_tokens'])) {
            // Responses API uses max_output_tokens
            $payload['max_output_tokens'] = $options['max_tokens'];
        }
        if (isset($options['max_output_tokens'])) {
            $payload['max_output_tokens'] = $options['max_output_tokens'];
        }
        if (isset($options['response_format'])) {
            $payload['response_format'] = $options['response_format'];
        }

        return $this->responses($payload);
    }

    public function assistantsCreateThreadRun(string $assistantId, array $inputs = [], array $options = []): array
    {
        $thread = $this->http->post('threads', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [ 'messages' => [ [ 'role' => 'user', 'content' => json_encode($inputs) ] ] ],
        ]);
        $threadData = json_decode((string) $thread->getBody(), true);

        $run = $this->http->post('threads/' . $threadData['id'] . '/runs', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [ 'assistant_id' => $assistantId ] + $options,
        ]);
        return [ 'thread' => $threadData, 'run' => json_decode((string) $run->getBody(), true) ];
    }

    public function assistantsGetRun(string $threadId, string $runId): array
    {
        $res = $this->http->get('threads/' . $threadId . '/runs/' . $runId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
            ],
        ]);
        return json_decode((string) $res->getBody(), true);
    }

    public function assistantsListMessages(string $threadId): array
    {
        $res = $this->http->get('threads/' . $threadId . '/messages', [
            'headers' => [ 'Authorization' => 'Bearer ' . $this->apiKey ],
        ]);
        return json_decode((string) $res->getBody(), true);
    }

    public function imagesGenerate(string $model, string $prompt, string $size = '1024x1024'): array
    {
        $res = $this->http->post('images/generations', [
            'headers' => [ 'Authorization' => 'Bearer ' . $this->apiKey, 'Content-Type' => 'application/json' ],
            'json' => [ 'model' => $model, 'prompt' => $prompt, 'size' => $size ],
        ]);
        return json_decode((string) $res->getBody(), true);
    }

    public function tts(string $model, string $voice, string $text, string $format = 'mp3'): string
    {
        $res = $this->http->post('audio/speech', [
            'headers' => [ 'Authorization' => 'Bearer ' . $this->apiKey, 'Content-Type' => 'application/json' ],
            'json' => [ 'model' => $model, 'voice' => $voice, 'input' => $text, 'format' => $format ],
        ]);
        return (string) $res->getBody();
    }
}


