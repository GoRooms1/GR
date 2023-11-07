<?php

namespace Domain\Bot\Models;

use App\Traits\CreatedAtOrdered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BotMessageTemplate extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use CreatedAtOrdered;

    protected static string $orderDirection = 'ASC';

    protected $fillable = [     
        'name',
        'header',
        'body',
        'url',
        'sort',
        'is_active',
        'users_count',
        'hotels_count',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime:Y-m-d\TH:i:sP',
        'updated_at' => 'datetime:Y-m-d\TH:i:sP',      
    ];
}
