<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Metro;
use Log;
use Lorisleiva\Actions\Action;

/**
 * @method static array run()
 */
final class GetAllMetrosByCityNameAction extends Action
{
    public function handle($city): array
    {       
        if (!$city)
            return array();
        else  
            return Metro::distinctName()->selectNameAndColor()->whereCity($city)->ordered()->get()->toArray(); 
    }
}
