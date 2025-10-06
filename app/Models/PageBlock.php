<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageBlock extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['uuid','page_id', 'block_id', 'content', 'sort_order'];

    protected $casts = [
        'content' => 'array',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }
}
