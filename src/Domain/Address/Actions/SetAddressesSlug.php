<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Action;

/**
 * @method static void run(Address $model)
 */
final class SetAddressesSlug extends Action
{
    /**
     * @param  Address  $model
     * @return void
     */
    public function handle(Address $model): void
    {
        $columns = ['region', 'area', 'city', 'city_district', 'street', 'city_area'];
        Cache::forget('sitemap.2g');

        foreach ($columns as $column) {
            /** @var ?string $attribute */
            $attribute = $model->getAttribute($column);
            
            if (! empty($attribute)) {
                GenerateAddressSlug::run($attribute);
            }            
        }
    }
}
