<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abv',
        'abv3',
        'abv3_alt',
        'code',
        'slug',
        'phonecode',
    ];

    public function users()
    {
        return $this->hasOne(User::class, 'country_id');
    }
}
