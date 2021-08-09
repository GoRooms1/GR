<?php

namespace App\Models;

use App\Traits\CreatedAtOrdered;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use CreatedAtOrdered;

    protected $fillable = [
        'name',
        'description',
        'model',
        'in_filter'
    ];

    public const MODELS = [
        Hotel::class => 'Отели',
        Room::class => 'Номера',
    ];

    public function scopeForHotels(Builder $builder)
    {
        return $builder->where('model', '=', Hotel::class);
    }

    public function scopeForRooms(Builder $builder)
    {
        return $builder->where('model', '=', Room::class);
    }

    public function scopeFiltered(Builder $builder)
    {
        return $builder->where('in_filter', '=', true);
    }

    public function getModelAttribute($value)
    {
        return self::MODELS[$value];
    }

    public function getCategoryAttribute()
    {
        $model = explode('\\', $this->getModelNameAttribute());
        $model = end($model);
        $model = mb_strtolower($model);
        return $model;
    }

    public function getModelNameAttribute()
    {
        return $this->getAttributes()['model'];
    }
}
