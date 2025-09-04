<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Block extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'schema',
        'view',
    ];

    protected $casts = [
        'schema' => 'array',
    ];

    /**
     * A Block belongs to a Page.
     */
    public function pageBlocks()
    {
        return $this->hasMany(PageBlock::class);
    }

}
