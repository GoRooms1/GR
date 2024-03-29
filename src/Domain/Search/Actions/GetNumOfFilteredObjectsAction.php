<?php

declare(strict_types=1);

namespace Domain\Search\Actions;

use Domain\Search\DataTransferObjects\ParamsData;
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
        if ($filters->room_filter == true) {
            return FilterRoomsCountAction::run($filters->rooms, $filters->hotels);
        } else {
            return FilterHotelsCountAction::run($filters->hotels);
        }
    }
}
