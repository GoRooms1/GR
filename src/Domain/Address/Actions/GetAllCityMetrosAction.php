<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Metro;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run($city)
 */
final class GetAllCityMetrosAction extends Action
{
    /**
     * @param $city   
     * @return Collection
     */
    public function handle($city): Collection
    {       
        if (!$city)
            return new Collection();
        else  
            return Metro::distinctName()->select('name', 'color', 'api_value')->whereCity($city)->ordered()->get(); 
    }
}
