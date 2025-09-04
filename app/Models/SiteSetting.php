<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
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
}