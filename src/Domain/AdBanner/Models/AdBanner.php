<?php

namespace Domain\AdBanner\Models;

use App\Traits\CreatedAtOrdered;
use Domain\AdBanner\DataTransferObjects\AdBannerData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AdBanner extends Model implements HasMedia
{    
    use HasFactory;
    use InteractsWithMedia;
    use CreatedAtOrdered;
    use WithData;
    
    protected $dataClass = AdBannerData::class;

    protected static string $orderDirection = 'ASC';

    protected $fillable = [     
        'name',
        'url',
        'email',
        'show_from',
        'show_to',           
        'is_show_always',
        'is_show_on_hotels',
        'is_show_on_rooms',
        'is_show_on_hotel',
        'is_show_on_hot',
        'cities',   
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_show_always' => 'boolean',
        'is_show_on_hotels' => 'boolean',
        'is_show_on_rooms' => 'boolean',
        'is_show_on_hotel' => 'boolean',
        'is_show_on_hot' => 'boolean',
        'cities' => 'array',
        'show_from' => 'date:Y-m-d',
        'show_to' => 'date:Y-m-d',
        'created_at' => 'datetime:Y-m-d\TH:i:sP',
        'updated_at' => 'datetime:Y-m-d\TH:i:sP',      
    ];
}
