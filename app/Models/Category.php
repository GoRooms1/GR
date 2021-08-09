<?php

namespace App\Models;

use App\Traits\CreatedAtOrdered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use CreatedAtOrdered;

    protected $fillable = [
        'name',
        'description',
        'hotel_id'
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
}
