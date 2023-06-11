<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Actions\GetMetroSlugAction;
use Domain\Address\Models\Address;
use Domain\Address\Models\Metro;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\DataCollection;
use Support\DataProcessing\Traits\CustomStr;

final class MetroSimpleData extends \Parent\DataTransferObjects\Data
{
    public function __construct(        
        public string $color,
        public string $name,        
        public int $distance,        
        public string $slug,        
    ) {
    }

    public static function fromModel(Metro $metro): self
    {
        return self::from([
            'color' => $metro->color,
            'name' => $metro->name,
            'distance' => $metro->distance,
            'slug' => CustomStr::getCustomSlug($metro->name),     
        ]);
    }

    public static function collectionWithAddressSlug(Collection $metros, Address $address): DataCollection
    {        
        $collection = [];

        foreach ($metros as $metro) {           
            $collection[] = MetroSimpleData::from([
                'color' => $metro->color,
                'name' => $metro->name,
                'distance' => $metro->distance,
                'slug' => route('address').GetMetroSlugAction::run($metro->name, $address->city),          
            ]);       
        }

        return new DataCollection(MetroSimpleData::class, $collection);
    }

}
