<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'topic_id' ,'title', 'content', 'video_url', 'resource_file', 'order'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
