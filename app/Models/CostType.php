<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sort'
    ];

    public static function getLastOrder()
    {
        return CostType::where('sort', '>', 0)->orderBy('sort', 'DESC')->first()->sort ?? 0;
    }
}
