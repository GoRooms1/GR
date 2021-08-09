<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostPeriod extends Model
{
    public function type()
    {
        return $this->belongsTo(CostType::class);
    }
}
