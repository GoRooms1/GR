<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Metro;
use Illuminate\Support\Collection;
use Log;
use Lorisleiva\Actions\Action;

/**
 * @method static array run()
 */
final class GetAllMetrosByCityNameAction extends Action
{
    public function handle($city): Collection | array
    {       
        if (!$city)
            return array();
        else  
            return Metro::distinctName()->select('name', 'color', 'api_value')->whereCity($city)->ordered()->get(); 
    }
}
