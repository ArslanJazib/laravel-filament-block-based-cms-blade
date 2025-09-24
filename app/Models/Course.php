<?php

namespace App\Models;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'instructor_id', 'title', 'slug', 'description', 'status', 'thumbnail', 'intro_video', 'price'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrollments()
    {
    
        return $this->hasMany(Enrollment::class);
    }

    public function comments()
    {
        return $this->hasManyThrough(CourseComment::class, Lesson::class, 'course_id', 'lesson_id');
    }

    public function ratings()
    {
        return $this->hasMany(CourseRating::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    public function latestFeedback($limit = 5)
    {
        return $this->ratings()
            ->with('user')
            ->latest()
            ->take($limit)
            ->get();
    }
}

