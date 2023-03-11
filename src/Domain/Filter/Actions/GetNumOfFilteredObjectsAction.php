<?php

declare(strict_types=1);

namespace Domain\Filter\Actions;

use Domain\Hotel\Actions\FilterHotelsCountAction;
use Domain\Room\Actions\FilterRoomsCountAction;
use Lorisleiva\Actions\Action;

/**
 * @method static int run(array $filters)
 */
final class GetNumOfFilteredObjectsAction extends Action
{
    /**
     * @param  array  $filters
     * @return int
     */
    public function handle(array $filters): int
    {
        $isRoomsFilter = $filters['isRoomsFilter'] ?? 'false';
        if ($isRoomsFilter == 'true') {
            return FilterRoomsCountAction::run($filters['rooms'] ?? [], $filters['hotels'] ?? []);
        } else {
            return FilterHotelsCountAction::run($filters['hotels'] ?? []);
        }
    }
}
