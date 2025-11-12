<?php

namespace App\Services\AI;

class AiProviderResolver
{
    public function text(string $task): array
    {
        $domain = config('ai.text');
        $provider = $domain['default'] ?? 'openai';
        $cfg = $domain['providers'][$provider] ?? [];
        return ['provider' => $provider, 'config' => $cfg, 'task' => $task];
    }

    public function image(): array
    {
        $domain = config('ai.image');
        $provider = $domain['default'] ?? 'openai';
        $cfg = $domain['providers'][$provider] ?? [];
        return ['provider' => $provider, 'config' => $cfg];
    }

    public function video(): array
    {
        $domain = config('ai.video');
        $provider = $domain['default'] ?? 'webhook';
        $cfg = $domain['providers'][$provider] ?? [];
        return ['provider' => $provider, 'config' => $cfg];
    }
}


