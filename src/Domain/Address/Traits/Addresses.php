<?php

declare(strict_types=1);

namespace Domain\Address\Traits;

use Domain\Address\Models\Address;
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
