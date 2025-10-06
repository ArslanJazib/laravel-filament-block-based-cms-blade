<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteSetting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'site_title',
        'favicon',
        'favicon_16x16',
        'favicon_32x32',
        'logo',
        'apple_touch_icon',
        'android_chrome_512x512',
        'android_chrome_192x192',
        'google_tag_manager',
        'header_menu',
        'footer_menu',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'header_menu' => 'array',
        'footer_menu' => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('favicons')->useDisk('public');
        $this->addMediaCollection('site_logos')->useDisk('public');
    }

    public function registerMediaConversions(Media $media = null): void
    {

    }
}
