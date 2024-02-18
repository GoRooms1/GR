<?php

declare(strict_types=1);

namespace Domain\Review\Actions;

use DB;
use Domain\Review\Models\RatingCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Parent\Actions\Action;

/**
 * @static @method Collection run()
 */
final class GetRatingCategories extends Action
{
    public function handle(): Collection
    {
        return Cache::remember(
            'rating_category',
            60 * 60 * 24 * 12,
            fn () => RatingCategory::orderBy('sort')->get()
        );
    }
}
