<?php

declare(strict_types=1);

namespace Domain\Room\ViewModels;

use Domain\Filter\Traits\ExtendedFiltersParamsTrait;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\Room\Actions\FilterRoomsAction;
use Domain\Room\DataTransferObjects\RoomData;

final class RoomViewModel extends \Parent\ViewModels\ViewModel
{
    use ExtendedFiltersParamsTrait;
    
    public array $params = [];
    
    public function __construct(array $params) {
        $this->params = $params;
    }

    public function model() {        
        return [
            'page' => PageData::fromPageDescription(GetPageDescriptionByUrlAction::run('/rooms'))->toArray(),
        ];
    }

    public function rooms()
    {
        return RoomData::collection(FilterRoomsAction::run($params['rooms'] ?? [], $params['hotels'] ?? [], true));
    }
}
