<?php

namespace App\Traits;

use App\Models\Address;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Addresses
{
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'model');
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model');
    }
}
