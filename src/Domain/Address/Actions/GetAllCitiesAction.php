<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run()
 */
final class GetAllCitiesAction extends Action
{
    public function handle(): Collection
    {       
        return Address::distinctCity()->select('city', 'region')->orderBy('city')->get();        
    }
}
