<?php

namespace App\Services\AI;

use App\Services\AI\Drivers\OpenAiDriver;
use App\Services\AI\Drivers\WebhookDriver;

class AiManager
{
    protected array $config;
    protected \App\Models\AiIntegration $aiIntegrationModel;

    /**
     * Accept optional dependencies so this manager is easier to test and DI-friendly.
     *
     * @param \App\Models\AiIntegration|null $aiIntegrationModel Optional AiIntegration model for lookups
     * @param array|null $config Optional config override
     */
    public function __construct(?\App\Models\AiIntegration $aiIntegrationModel = null, ?array $config = null)
    {
        $this->config = $config ?? config('ai', []);
        $this->aiIntegrationModel = $aiIntegrationModel ?? new \App\Models\AiIntegration();
    }

    /**
     * domain: text|image|video|tts
     */
    public function driver(string $domain)
    {
        $domainCfg = $this->config[$domain] ?? [];
        $provider = $domainCfg['default'] ?? 'openai';
        $providers = $domainCfg['providers'] ?? [];
        $cfg = $providers[$provider] ?? [];

        try {
            $active = $this->aiIntegrationModel->where('model_type', $domain)
                ->where('is_active', true)
                ->orderBy('priority_order', 'asc')
                ->first();
            if ($active) {
                // override provider key and inject model name into config
                $provider = $active->provider;
                $cfg = $providers[$provider] ?? $cfg;
                if (!empty($active->model)) {
                    // ensure drivers can see a 'model' key
                    $cfg['model'] = $active->model;
                }
            }
        } catch (\Throwable $e) {
            // ignore DB errors here so manager can be constructed in bootstrap
        }

        switch ($provider) {
            case 'openai':
                return new OpenAiDriver($cfg);
            case 'anthropic':
                return new \App\Services\AI\Drivers\AnthropicDriver($cfg);
            case 'perplexity':
                return new \App\Services\AI\Drivers\PerplexityDriver($cfg);
            case 'gemini':
                return new \App\Services\AI\Drivers\GeminiDriver($cfg);
            case 'llama':
            case 'lama':
                return new \App\Services\AI\Drivers\LlamaDriver($cfg);
            case 'midjourney':
                return new \App\Services\AI\Drivers\MidjourneyDriver($cfg);
            case 'grok':
                return new \App\Services\AI\Drivers\GrokDriver($cfg);
            case 'webhook':
            default:
                return new WebhookDriver($cfg);
        }
    }
}
