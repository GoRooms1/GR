<?php

declare(strict_types=1);

namespace Domain\Room\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CostsCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost_id',
        'value',
        'avg_value',
        'discount',
        'date_from',
        'date_to',       
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'date_from' => 'date:Y-m-d',
        'date_to' => 'date:Y-m-d',
        'created_at' => 'datetime:Y-m-d\TH:i:sP',
        'updated_at' => 'datetime:Y-m-d\TH:i:sP',      
    ];

    public function cost(): BelongsTo
    {
        return $this->belongsTo(Cost::class);
    }
}
