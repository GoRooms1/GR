<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Rating extends Model
{
    protected $fillable = [
        'category_id',
        'value',
    ];

    protected $with = [
        'review',
        'category',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(RatingCategory::class);
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        self::creating(function(self $rating) {
            Cache::forget('sitemap.2g');
        });
        self::updating(function(self $rating) {
            Cache::forget('sitemap.2g');
        });
        self::deleting(function(self $rating) {
            Cache::forget('sitemap.2g');
        });
    }
}
