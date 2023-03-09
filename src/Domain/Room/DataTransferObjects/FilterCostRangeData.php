<?php

declare(strict_types=1);

namespace Domain\Room\DataTransferObjects;

final class FilterCostRangeData extends \Parent\DataTransferObjects\Data
{
    public function __construct(        
        public string $key,
        public string $name,
        public int $from,
        public int $to,
    ) {
    }

    public static function fromRange(int $from, int $to): self
    {
        $key = '';
        $name = '';
        if ($from > 0 && $to > 0) {
            $key = $from.'-'.$to;
            $name = $from.'-'.$to;
        }
        elseif ($from == 0 && $to > 0) {
            $key = $from.'-'.$to;
            $name = 'До '.$to;
        }
        elseif ($from > 0 && $to == 0) {
            $key = $from.'-'.PHP_INT_MAX;
            $name = 'От '.$from;
        }

        return self::from([
            'key' => $key,
            'name' => $name.' ₽',
            'from' => $from,
            'to' => $to > 0 ? $to : PHP_INT_MAX,
        ]);
    }
   
}
