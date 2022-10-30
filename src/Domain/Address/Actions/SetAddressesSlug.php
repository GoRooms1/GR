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
        $slugs = GetSlugFromAddress::run($model);
        Cache::forget('sitemap.2g');
        foreach ($slugs as $slug) {
            DB::table('address_slug')->updateOrInsert(['address' => $slug->address], $slug->toArray());
        }
    }
}
