<?php

namespace App\Models;

use App\Traits\ClearValidated;
use App\Traits\CreatedAtOrdered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;


class Review extends Model
{
    use ClearValidated;
    use CreatedAtOrdered;

    const PER_PAGE = 6;

    protected $fillable = [
        'name',
        'city',
        'room',
        'text',
        'hotel_id',
    ];

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class)->with('category');
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
}
