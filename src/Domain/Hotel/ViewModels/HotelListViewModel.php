<?php

declare(strict_types=1);

namespace Domain\Hotel\ViewModels;

use Arr;
use Domain\Filter\Traits\FiltersParamsTrait;
use Domain\Hotel\Actions\FilterHotelsAction;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;

final class HotelListViewModel extends \Parent\ViewModels\ViewModel
{
    use FiltersParamsTrait;
    
    public array $params = [];
    public string|null $url;
    public string|null $queryString;
    
    public function __construct(array $params, string|null $url = null) {
        $this->params = $params;
        $this->url = $url ?? '/hotels';        
    }

    public function model() {        
        return [
            'page' => PageData::fromPageDescription(GetPageDescriptionByUrlAction::run($this->url))->toArray(),
        ];
    }

    public function hotels() {        
        return HotelData::Collection(FilterHotelsAction::run($this->params['hotels'] ?? [], true));
    }

    public function query_string() {      
        return Arr::query($this->params);
    }
}
