<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Lesson extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['course_id', 'topic_id' ,'title', 'content', 'video_url', 'resource_files', 'order', 'duration'];

    protected $casts = [
        'resource_files' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function progress()
    {
        return $this->belongsTo(Progress::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('lesson-videos')->useDisk('public');
        $this->addMediaCollection('lesson-resources')->useDisk('public');
    }

    public function registerMediaConversions(Media $media = null): void
    {

    }
}
