<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Action;
use Support\DataProcessing\Traits\CustomStr;

/**
 * @method static void run(string $name)
 */
final class GenerateAddressSlug extends Action
{
    public function handle(string $name): void
    {        
        DB::table('address_slug')->updateOrInsert(['slug' => CustomStr::getCustomSlug($name)], [
            'address' => $name,
            'slug' => CustomStr::getCustomSlug($name),
        ]);
    }
}
