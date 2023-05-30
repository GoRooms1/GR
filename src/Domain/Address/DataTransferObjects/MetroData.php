<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Actions\GetMetroSlugAction;
use Domain\Address\Models\Address;
use Domain\Address\Models\Metro;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\DataCollection;
use Support\DataProcessing\Traits\CustomStr;

final class MetroData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $color,
        public string $name,
        public string $api_value,
        public int $distance,
        public int $hotel_id,
        public bool $custom,
        public string $slug,        
    ) {
    }

    public static function fromModel(Metro $metro): self
    {
        return self::from([
            ...$metro->toArray(),
            'slug' => CustomStr::getCustomSlug($metro->name),          
        ]);
    }

    public static function collectionWithAddressSlug(Collection $metros, Address $address): DataCollection
    {        
        $collection = [];

        foreach ($metros as $metro) {           
            $collection[] = MetroData::from([
                ...$metro->toArray(),
                'slug' => route('address').GetMetroSlugAction::run($metro->name, $address->city),          
            ]);       
        }

        return new DataCollection(MetroData::class, $collection);
    }

}
