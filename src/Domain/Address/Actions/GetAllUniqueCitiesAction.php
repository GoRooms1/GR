<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static array run()
 */
final class GetAllUniqueCitiesAction extends Action
{
    public function handle(): Collection
    {       
        return Address::distinctCity()->select('city as name', 'region')->get();           
    }
}
