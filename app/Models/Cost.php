<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cost extends Model
{
    protected $fillable = [
        'value',
        'description',
        'type_id',
        'user_id'
    ];

    protected $with = [
        'type'
    ];

    public function type()
    {
        return $this->belongsTo(CostType::class);
    }

    public function scopeMinValues(Builder $query, Array $rooms)
    {
        return $query->whereIn('model_id', $rooms)->where('model_type', Room::class)->min('value')->groupBy('type_id');
    }
}
