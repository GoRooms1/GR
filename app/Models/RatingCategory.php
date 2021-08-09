<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sort',
    ];
}
