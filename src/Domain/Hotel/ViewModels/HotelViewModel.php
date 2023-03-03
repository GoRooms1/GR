<?php

declare(strict_types=1);

namespace Domain\Hotel\ViewModels;

use Domain\Filter\Traits\ExtendedFiltersParamsTrait;
use Domain\Hotel\Actions\FilterHotelsAction;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;

final class HotelViewModel extends \Parent\ViewModels\ViewModel
{
    use ExtendedFiltersParamsTrait;
    
    public array $params = [];
    
    public function __construct(array $params) {
        $this->params = $params;
    }

    public function model() {        
        return [
            'page' => PageData::fromPageDescription(GetPageDescriptionByUrlAction::run('/hotels'))->toArray(),
        ];
    }

    public function hotels() {
        return HotelData::Collection(FilterHotelsAction::run($params['hotels'] ?? [], true));
    }
}
