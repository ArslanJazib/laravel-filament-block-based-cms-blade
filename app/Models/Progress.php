<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }
    
    public function lesson() {
        return $this->belongsTo(Lesson::class);
    }
}
