<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function instructor() {
        return $this->belongsTo(User::class, 'instructor_id');
    }
    public function lessons() {
        return $this->hasMany(Lesson::class);
    }
    public function students() {
        return $this->belongsToMany(User::class, 'enrollments');
    }
}
