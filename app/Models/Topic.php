<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'order',
    ];

    // Each Topic belongs to a Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // A Topic can have many Lessons
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
