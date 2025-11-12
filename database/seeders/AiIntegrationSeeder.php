<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AiIntegration;
use Carbon\Carbon;

class AiIntegrationSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // TEXT MODELS
            [
                'provider' => 'openai',
                'model' => 'gpt-4o-mini',
                'model_type' => 'text',
                'display_name' => 'GPT-4o Mini',
                'is_active' => true,
                'priority_order' => 1,
                'max_requests_per_day' => 1000,
                'max_requests_per_month' => 20000,
                'current_request_count' => 0,
                'estimated_cost_per_request' => 0.002,
                'alerts_at' => 0.8,
                'last_reset_at' => Carbon::now(),
            ],
            [
                'provider' => 'gemini',
                'model' => 'gemini-1.5-flash',
                'model_type' => 'text',
                'display_name' => 'Gemini 1.5 Flash',
                'is_active' => true,
                'priority_order' => 2,
                'max_requests_per_day' => 800,
                'max_requests_per_month' => 15000,
                'current_request_count' => 0,
                'estimated_cost_per_request' => 0.0015,
                'alerts_at' => 0.8,
                'last_reset_at' => Carbon::now(),
            ],
            [
                'provider' => 'llama',
                'model' => 'llama-3-70b',
                'model_type' => 'text',
                'display_name' => 'LLaMA 3 70B',
                'is_active' => true,
                'priority_order' => 3,
                'max_requests_per_day' => 500,
                'max_requests_per_month' => 10000,
                'current_request_count' => 0,
                'estimated_cost_per_request' => 0.005,
                'alerts_at' => 0.8,
                'last_reset_at' => Carbon::now(),
            ],
            [
                'provider' => 'perplexity',
                'model' => 'pplx-7b-chat',
                'model_type' => 'text',
                'display_name' => 'Perplexity 7B Chat',
                'is_active' => true,
                'priority_order' => 4,
                'max_requests_per_day' => 700,
                'max_requests_per_month' => 12000,
                'current_request_count' => 0,
                'estimated_cost_per_request' => 0.001,
                'alerts_at' => 0.8,
                'last_reset_at' => Carbon::now(),
            ],

            // IMAGE MODELS
            [
                'provider' => 'midjourney',
                'model' => 'midjourney-v6',
                'model_type' => 'image',
                'display_name' => 'Midjourney v6',
                'is_active' => true,
                'priority_order' => 5,
                'max_requests_per_day' => 200,
                'max_requests_per_month' => 4000,
                'current_request_count' => 0,
                'estimated_cost_per_request' => 0.05,
                'alerts_at' => 0.8,
                'last_reset_at' => Carbon::now(),
            ],
            [
                'provider' => 'openai',
                'model' => 'dall-e-3',
                'model_type' => 'image',
                'display_name' => 'DALL·E 3',
                'is_active' => true,
                'priority_order' => 6,
                'max_requests_per_day' => 200,
                'max_requests_per_month' => 4000,
                'current_request_count' => 0,
                'estimated_cost_per_request' => 0.05,
                'alerts_at' => 0.8,
                'last_reset_at' => Carbon::now(),
            ],

            // VIDEO MODELS
            [
                'provider' => 'google',
                'model' => 'sora-video',
                'model_type' => 'video',
                'display_name' => 'Sora Video',
                'is_active' => false,
                'priority_order' => 7,
                'max_requests_per_day' => 100,
                'max_requests_per_month' => 2000,
                'current_request_count' => 0,
                'estimated_cost_per_request' => 0.08,
                'alerts_at' => 0.8,
                'last_reset_at' => Carbon::now(),
            ],

            // TTS MODELS
            [
                'provider' => 'openai',
                'model' => 'tts-1',
                'model_type' => 'tts',
                'display_name' => 'OpenAI TTS-1',
                'is_active' => true,
                'priority_order' => 8,
                'max_requests_per_day' => 300,
                'max_requests_per_month' => 6000,
                'current_request_count' => 0,
                'estimated_cost_per_request' => 0.001,
                'alerts_at' => 0.8,
                'last_reset_at' => Carbon::now(),
            ],
        ];

        foreach ($data as $item) {
            AiIntegration::create($item);
        }
    }
}
