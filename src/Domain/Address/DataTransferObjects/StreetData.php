<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

final class StreetData extends \Spatie\DataTransferObject\DataTransferObject
{
    public int $id;

    public string $name;

    public string $city;

    public ?string $area;

    public ?string $district;
}
