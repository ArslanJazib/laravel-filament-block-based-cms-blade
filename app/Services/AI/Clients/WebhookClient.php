<?php

namespace App\Services\AI\Clients;

use GuzzleHttp\Client;

class WebhookClient
{
    protected Client $http;
    protected string $baseUrl;
    protected ?string $authHeader;

    public function __construct(string $baseUrl, ?string $authHeader = null)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->authHeader = $authHeader;
        $this->http = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 120,
        ]);
    }

    public function postJson(string $path, array $payload): array
    {
        $headers = [ 'Content-Type' => 'application/json' ];
        if ($this->authHeader) {
            $headers['Authorization'] = $this->authHeader;
        }
        $res = $this->http->post(ltrim($path, '/'), [ 'headers' => $headers, 'json' => $payload ]);
        return json_decode((string) $res->getBody(), true);
    }
}


