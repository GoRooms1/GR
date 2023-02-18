<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Lorisleiva\Actions\Action;

/**
 * @method static array run()
 */
final class GetAllCitiesNamesAction extends Action
{
    public function handle(): array
    {       
        return Address::distinctCity()->pluck('city')->toArray();           
    }
}
