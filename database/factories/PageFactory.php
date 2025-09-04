<?php

namespace Database\Factories;

use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition()
    {
        $title = 'Test Page';

        return [
            'title' => $title,
            'slug' => Str::slug($title). Str::random(5), // avoid duplicates
            'is_published' => true,
            'published_at' => Carbon::now(),
        ];
    }
}
