<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiIntegration extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'model',
        'display_name',
        'is_active',
        'priority_order',
        'max_requests_per_day',
        'max_requests_per_month',
        'current_request_count',
        'estimated_cost_per_request',
        'alerts_at',
        'last_reset_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'alerts_at' => 'decimal:2',
        'estimated_cost_per_request' => 'decimal:5',
        'last_reset_at' => 'datetime',
    ];

    /**
     * Check if this model has reached its threshold limit.
     */
    public function isOverThreshold(): bool
    {
        if ($this->max_requests_per_day === 0) {
            return false;
        }

        return $this->current_request_count >= $this->max_requests_per_day;
    }

    /**
     * Increment the usage count.
     */
    public function incrementUsage(): void
    {
        $this->increment('current_request_count');
    }
}
