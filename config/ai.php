<?php

return [

    /*
    |--------------------------------------------------------------------------
    | TEXT GENERATION (Responses API)
    |--------------------------------------------------------------------------
    | Unified interface for text-based generation using multiple providers.
    | Each provider uses the "response" driver instead of the Assistant API.
    */

    'text' => [
        'default' => env('AI_TEXT_PROVIDER', 'openai'),

        'providers' => [

            'openai' => [
                'driver' => 'response',
                'api_key' => env('OPENAI_API_KEY'),
                'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
                'models' => [
                    'draft'   => env('OPENAI_MODEL_DRAFT', 'gpt-4o-mini'),
                    'refine'  => env('OPENAI_MODEL_REFINE', 'gpt-4.1'),
                    'quiz'    => env('OPENAI_MODEL_QUIZ', 'gpt-4o-mini'),
                    'outline' => env('OPENAI_MODEL_OUTLINE', 'gpt-4o-mini'),
                    'lesson'  => env('OPENAI_MODEL_LESSON', 'gpt-4o-mini'),
                ],
            ],

            'anthropic' => [
                'driver' => 'response',
                'api_key' => env('ANTHROPIC_API_KEY'),
                'base_url' => env('ANTHROPIC_BASE_URL', 'https://api.anthropic.com/v1'),
                'models' => [
                    'draft'   => env('ANTHROPIC_MODEL_DRAFT', 'claude-3-haiku'),
                    'refine'  => env('ANTHROPIC_MODEL_REFINE', 'claude-3-opus'),
                    'quiz'    => env('ANTHROPIC_MODEL_QUIZ', 'claude-3-haiku'),
                    'outline' => env('ANTHROPIC_MODEL_OUTLINE', 'claude-3-haiku'),
                    'lesson'  => env('ANTHROPIC_MODEL_LESSON', 'claude-3-haiku'),
                ],
            ],

            'gemini' => [
                'driver' => 'response',
                'api_key' => env('GEMINI_API_KEY'),
                'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),
                'models' => [
                    'draft'   => env('GEMINI_MODEL_DRAFT', 'gemini-1.5-flash'),
                    'refine'  => env('GEMINI_MODEL_REFINE', 'gemini-1.5-pro'),
                    'quiz'    => env('GEMINI_MODEL_QUIZ', 'gemini-1.5-flash'),
                    'outline' => env('GEMINI_MODEL_OUTLINE', 'gemini-1.5-flash'),
                    'lesson'  => env('GEMINI_MODEL_LESSON', 'gemini-1.5-flash'),
                ],
            ],

            'llama' => [
                'driver' => 'response',
                'api_key' => env('LLAMA_API_KEY'),
                'base_url' => env('LLAMA_BASE_URL', 'https://api.meta.ai/v1'),
                'models' => [
                    'draft'   => env('LLAMA_MODEL_DRAFT', 'llama-3.1-70b'),
                    'refine'  => env('LLAMA_MODEL_REFINE', 'llama-3.1-405b'),
                    'quiz'    => env('LLAMA_MODEL_QUIZ', 'llama-3.1-70b'),
                    'outline' => env('LLAMA_MODEL_OUTLINE', 'llama-3.1-70b'),
                    'lesson'  => env('LLAMA_MODEL_LESSON', 'llama-3.1-70b'),
                ],
            ],

            'grok' => [
                'driver' => 'response',
                'api_key' => env('GROK_API_KEY'),
                'base_url' => env('GROK_BASE_URL', 'https://api.x.ai/v1'),
                'models' => [
                    'draft'   => env('GROK_MODEL_DRAFT', 'grok-1'),
                    'refine'  => env('GROK_MODEL_REFINE', 'grok-1'),
                    'quiz'    => env('GROK_MODEL_QUIZ', 'grok-1'),
                    'outline' => env('GROK_MODEL_OUTLINE', 'grok-1'),
                    'lesson'  => env('GROK_MODEL_LESSON', 'grok-1'),
                ],
            ],

            'perplexity' => [
                'driver' => 'response',
                'api_key' => env('PERPLEXITY_API_KEY'),
                'base_url' => env('PERPLEXITY_BASE_URL', 'https://api.perplexity.ai'),
                'models' => [
                    'draft'   => env('PERPLEXITY_MODEL_DRAFT', 'pplx-70b-online'),
                    'refine'  => env('PERPLEXITY_MODEL_REFINE', 'pplx-70b-online'),
                    'quiz'    => env('PERPLEXITY_MODEL_QUIZ', 'pplx-70b-online'),
                    'outline' => env('PERPLEXITY_MODEL_OUTLINE', 'pplx-70b-online'),
                    'lesson'  => env('PERPLEXITY_MODEL_LESSON', 'pplx-70b-online'),
                ],
            ],

            'webhook' => [
                'driver' => 'webhook',
                'base_url' => env('AI_TEXT_WEBHOOK_BASE_URL'),
                'auth_header' => env('AI_TEXT_WEBHOOK_AUTH'),
                'endpoints' => [
                    'outline' => env('AI_TEXT_WEBHOOK_OUTLINE'),
                    'lesson'  => env('AI_TEXT_WEBHOOK_LESSON'),
                    'quiz'    => env('AI_TEXT_WEBHOOK_QUIZ'),
                    'refine'  => env('AI_TEXT_WEBHOOK_REFINE'),
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IMAGE GENERATION
    |--------------------------------------------------------------------------
    | Supports DALL·E, Midjourney, Google Imagen 3, and fallback webhooks.
    */

    'image' => [
        'default' => env('AI_IMAGE_PROVIDER', 'openai'),

        'providers' => [
            'openai' => [
                'api_key' => env('OPENAI_API_KEY'),
                'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
                'model' => env('OPENAI_IMAGE_MODEL', 'dall-e-3'),
            ],
            'midjourney' => [
                'api_key' => env('MIDJOURNEY_API_KEY'),
                'base_url' => env('MIDJOURNEY_BASE_URL', 'https://api.midjourney.com'),
                'model' => env('MIDJOURNEY_MODEL', 'midjourney-v5'),
            ],
            'gemini' => [
                'api_key' => env('GEMINI_API_KEY'),
                'base_url' => env('GEMINI_IMAGE_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),
                'model' => env('GEMINI_IMAGE_MODEL', 'imagen-3'),
            ],
            'webhook' => [
                'base_url' => env('AI_IMAGE_WEBHOOK_BASE_URL'),
                'auth_header' => env('AI_IMAGE_WEBHOOK_AUTH'),
                'endpoint' => env('AI_IMAGE_WEBHOOK_GENERATE'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | TEXT TO SPEECH
    |--------------------------------------------------------------------------
    */

    'tts' => [
        'default' => env('AI_TTS_PROVIDER', 'openai'),

        'providers' => [
            'openai' => [
                'api_key' => env('OPENAI_API_KEY'),
                'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
                'model' => env('OPENAI_TTS_MODEL', 'tts-1'),
                'voice' => env('OPENAI_TTS_VOICE', 'alloy'),
            ],
            'webhook' => [
                'base_url' => env('AI_TTS_WEBHOOK_BASE_URL'),
                'auth_header' => env('AI_TTS_WEBHOOK_AUTH'),
                'endpoint' => env('AI_TTS_WEBHOOK_SYNTH'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | VIDEO GENERATION
    |--------------------------------------------------------------------------
    | Supports OpenAI Sora, Google Veo3, and custom Webhook pipelines.
    */

    'video' => [
        'default' => env('AI_VIDEO_PROVIDER', 'openai'),

        'providers' => [
            'openai' => [
                'api_key' => env('OPENAI_API_KEY'),
                'base_url' => env('GEMINI_VIDEO_BASE_URL', 'https://api.openai.com/v1'),
                'model' => env('GEMINI_VIDEO_MODEL', 'sora-1'),
            ],
            'gemini' => [
                'api_key' => env('GEMINI_API_KEY'),
                'base_url' => env('GEMINI_VIDEO_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),
                'model' => env('GEMINI_VIDEO_MODEL', 'veo-3'),
            ],
            'webhook' => [
                'base_url' => env('AI_VIDEO_WEBHOOK_BASE_URL'),
                'auth_header' => env('AI_VIDEO_WEBHOOK_AUTH'),
                'endpoint' => env('AI_VIDEO_WEBHOOK_RENDER'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | GLOBAL DEFAULTS
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'temperature' => (float) env('AI_TEMPERATURE', 0.2),
        'max_output_tokens' => (int) env('AI_MAX_OUTPUT_TOKENS', 2000),
        'poll_ms' => (int) env('AI_POLL_MS', 1200),
        'poll_timeout_ms' => (int) env('AI_POLL_TIMEOUT_MS', 300000),
    ],
];
