<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Lorisleiva\Actions\Action;

/**
 * @method static string run(string $start, ?string $end)
 */
final class GenerateInfoDescForPeriod extends Action
{
    public function handle(string $start, ?string $end): string
    {
        if ($end) {
            return 'С '.$start.' до '.$end;
        }

        return 'От '.$start.GetEndingValue::run((int) $start);
    }
}
