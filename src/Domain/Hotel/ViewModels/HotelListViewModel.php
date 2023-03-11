<?php

declare(strict_types=1);

namespace Domain\Hotel\ViewModels;

use Domain\Filter\Traits\FiltersParamsTrait;
use Domain\Hotel\Actions\FilterHotelsAction;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;

final class HotelListViewModel extends \Parent\ViewModels\ViewModel
{
    use FiltersParamsTrait;

    public array $params = [];

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function model()
    {
        return [
            'page' => PageData::fromPageDescription(GetPageDescriptionByUrlAction::run('/hotels'))->toArray(),
        ];
    }

    public function hotels()
    {
        return HotelData::Collection(FilterHotelsAction::run($this->params['hotels'] ?? [], true));
    }
}
