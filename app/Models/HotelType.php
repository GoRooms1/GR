<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HotelType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sort'
    ];

    public function hotels(): HasMany
    {
        return $this->hasMany(Hotel::class);
    }
}
