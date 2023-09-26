<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Lorisleiva\Actions\Action;
use Lang;

/**
 * @method static string run(string $book_type, ?int $hours_count, ?int $days_count)
 */
final class GenerateOrderedOnTextAction extends Action
{
    public function handle(string $book_type, ?int $hours_count, ?int $days_count): string
    {
       /** @var string $orderedOn */
       $orderedOn = '';
       if ($book_type == 'hour') {
           /** @var int $hoursCount */
           $hoursCount = $hours_count;
           $orderedOn = $hours_count.' '.Lang::choice('час|часа|часов', $hoursCount, [], 'ru');
       }

       if ($book_type == 'night') {
           $orderedOn = 'ночь';
       }

       if ($book_type == 'day') {
           /** @var int $daysCount */
           $daysCount = $days_count;
           $orderedOn = $days_count.' '.Lang::choice('сутки|суток|суток', $daysCount, [], 'ru');
       }

       return $orderedOn;
    }
}
