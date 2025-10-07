<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogCategory extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = ['name','slug','parent_id','description','featured_image','meta_title','meta_description'];

    public function blogs() {
        return $this->hasMany(Blog::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
        ->useDisk('public');
    }

    public function registerMediaConversions(Media $media = null): void
    {

    }
}

