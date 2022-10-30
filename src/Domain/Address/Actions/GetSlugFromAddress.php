<?php

namespace Domain\Address\Actions;

use Domain\Address\DataTransferObjects\AddressSlugData;
use Domain\Address\Models\Address;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Action;

/**
 * @method static AddressSlugData[] run(Address $address)
 */
final class GetSlugFromAddress extends Action
{
    /**
     * @param  Address  $address
     * @return AddressSlugData[]
     */
    public function handle(Address $address): array
    {
        $columns = ['region', 'area', 'city', 'city_district', 'street', 'city_area'];

        $slugs = [];
        foreach ($columns as $column) {
            /** @var ?string $attribute */
            $attribute = $address->getAttribute($column);
            if (! empty($attribute)) {
                $slugs[] = new AddressSlugData(address: $attribute, slug: Str::slug($attribute));
            }
        }

        return $slugs;
    }
}
