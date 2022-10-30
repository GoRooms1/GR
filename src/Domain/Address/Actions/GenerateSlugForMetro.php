<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Action;

/**
 * @method static void run(string $name)
 */
final class GenerateSlugForMetro extends Action
{
    public function handle(string $name): void
    {
        DB::table('address_slug')->updateOrInsert(['address' => $name], [
            'address' => $name,
            'slug' => Str::slug($name),
        ]);
    }
}
