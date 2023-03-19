<?php

declare(strict_types=1);

namespace Domain\Filter\Actions;

use Domain\Filter\DataTransferObjects\ParamsData;
use Domain\Hotel\Actions\FilterHotelsCountAction;
use Domain\Room\Actions\FilterRoomsCountAction;
use Lorisleiva\Actions\Action;

/**
 * @method static int run(ParamsData $filters)
 */
final class GetNumOfFilteredObjectsAction extends Action
{
    /**
     * @param  ParamsData  $filters
     * @return int
     */
    public function handle(ParamsData $filters): int
    {
        if ($filters->isRoomsFilter == true) {
            return FilterRoomsCountAction::run($filters->rooms, $filters->hotels);
        } else {
            return FilterHotelsCountAction::run($filters->hotels);
        }
    }
}
