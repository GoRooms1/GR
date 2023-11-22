<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

use Domain\Address\DataTransferObjects\AddressSimpleData;
use Domain\Hotel\Actions\MinimumCostFilteredValueCalculation;
use Domain\Hotel\Actions\MinimumDiscountCostFilteredValueCalculation;
use Domain\Hotel\Models\Hotel;
use Domain\Search\DataTransferObjects\ParamsData;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Lazy;

final class HotelMapData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,        
        public Lazy|AddressSimpleData|null $address,
        public float $min_cost_value,
        public float $min_cost_discount_value,
    ) {
    }

    public static function fromModel(Hotel $hotel): self
    {
        return self::from([
            ...$hotel->toArray(),           
            'address' => Lazy::whenLoaded('address', $hotel, fn () => AddressSimpleData::from($hotel->address)),
            'min_cost_value' => MinimumCostFilteredValueCalculation::run($hotel, ParamsData::from(ParamsData::empty())),
            'min_cost_discount_value' => MinimumDiscountCostFilteredValueCalculation::run($hotel, ParamsData::from(ParamsData::empty())),
        ]);
    }

    /**     
     * @param Collection $hotels
     * @param ParamsData $paramsData
     * @return array
     */
    public static function fromCollectionWithFilters(Collection $hotels, ParamsData $paramsData): array
    {
        $dataCollection = [];        
        
        foreach ($hotels as $hotel) {
            $dataCollection[] = HotelMapData::from([
                ...$hotel->toArray(),
                'address' => AddressSimpleData::from($hotel->address),
                'min_cost_value' => MinimumCostFilteredValueCalculation::run($hotel, $paramsData),
                'min_cost_discount_value' => MinimumDiscountCostFilteredValueCalculation::run($hotel, $paramsData),
                
            ]);
        }

        return  $dataCollection;
    }
}
