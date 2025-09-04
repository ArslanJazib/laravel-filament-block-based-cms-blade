<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'status',
    ];

    /**
     * A Page has many Blocks.
     */
    public function blocks()
    {
        return $this->hasMany(PageBlock::class)->orderBy('sort_order');
    }
}
