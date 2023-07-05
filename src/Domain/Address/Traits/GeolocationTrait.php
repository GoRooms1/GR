<?php

declare(strict_types=1);

namespace Domain\Address\Traits;

use Closure;
use Domain\Address\Actions\GetLocationFromSession;

trait GeolocationTrait
{
    public function location(): Closure
    {
        return fn() => GetLocationFromSession::run(request()->ip());
    }
}
