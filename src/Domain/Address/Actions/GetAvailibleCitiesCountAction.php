<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Lorisleiva\Actions\Action;

/**
 * @method static int run()
 */
final class GetAvailibleCitiesCountAction extends Action
{
    public function handle(): int
    {
        return Address::joinModeratedObjects()->distinctCity()->whereNotNull('city')->count('city');
    }
}
