<?php
declare(strict_types=1);

namespace Domain\Room\DataTransferObjects;

class ParamsData extends \Parent\DataTransferObjects\Data
{
    /**
     * @param  array  $rooms
     */
    public function __construct(
        public array $rooms = []
    )
    {
    }

    public static function fromRequest()
    {

    }
}