<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'lesson_id',
        'completed',
        'completed_at',
        'progress_percent',
        'current_second',
        'total_seconds',
        'last_accessed_at',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'completed' => true,
            'completed_at' => Carbon::now(),
            'progress_percent' => 100,
        ]);
    }

    public function updateProgress(int $percent): void
    {
        $this->update([
            'progress_percent' => min(100, max(0, $percent)),
            'last_accessed_at' => Carbon::now(),
        ]);
    }

    public function updateVideoProgress(int $currentSecond, int $totalSeconds): void
    {
        $this->update([
            'current_second' => $currentSecond,
            'total_seconds' => $totalSeconds,
            'progress_percent' => $totalSeconds > 0
                ? min(100, round(($currentSecond / $totalSeconds) * 100))
                : $this->progress_percent,
            'last_accessed_at' => Carbon::now(),
        ]);
    }
}
