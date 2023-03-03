<?php

declare(strict_types=1);

namespace Domain\Filter\Traits;

use Domain\Address\Actions\GetAllMetrosByCityNameAction;
use Domain\Address\Actions\GetAllUniqueCitiesAction;
use Domain\Address\DataTransferObjects\CityData;
use Domain\Address\DataTransferObjects\SimpleMetroData;
use Domain\Filter\Actions\GetNumOfFilteredObjectsAction;

trait FiltersParamsTrait {

    public function cities() {
        return CityData::collection(GetAllUniqueCitiesAction::run());
    }

    public function metros() {
        return SimpleMetroData::collection(GetAllMetrosByCityNameAction::run($this->params['hotels']['city'] ?? null));
    }

    public function total() {
        return GetNumOfFilteredObjectsAction::run($this->params);
    }
}