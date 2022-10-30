<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Hotel\Models\Hotel;
use Domain\Hotel\Scopes\ModerationScope;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Action;

/**
 * @method static string run(HotelData $hotelData)
 */
final class GenerateSlugForHotel extends Action
{
    public function handle(HotelData $hotelData): string
    {
        $i = 0;
        do {
            $slug = Str::slug($hotelData->name).($i > 0 ? '-'.$i : '');
            $i++;
        } while (Hotel::withoutGlobalScope(ModerationScope::class)->whereSlug($slug)->exists());

        return $slug;
    }
}
