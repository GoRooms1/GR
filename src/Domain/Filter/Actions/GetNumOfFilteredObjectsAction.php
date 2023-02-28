<?php

declare(strict_types=1);

namespace Domain\Filter\Actions;

use Domain\Hotel\Actions\FilterHotelsCountAction;
use Lorisleiva\Actions\Action;

/**
 * @method static int run()
 */
final class GetNumOfFilteredObjectsAction extends Action
{
    public function handle(array $filters): int
    {       
        return FilterHotelsCountAction::run($filters['hotels'] ?? []);           
    }
}
