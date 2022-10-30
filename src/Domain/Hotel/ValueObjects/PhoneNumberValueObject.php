<?php

declare(strict_types=1);

namespace Domain\Hotel\ValueObjects;

use Parent\ValueObjects\ValueObject;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * Class PhoneNumberValueObject
 */
final class PhoneNumberValueObject extends PhoneNumber implements ValueObject
{
    public function isNull(): bool
    {
        $value = parent::getRawNumber();

        return strlen($value) < 1;
    }

    public function isSame(ValueObject $object): bool
    {
        return $this->toNative() === $object->toNative();
    }

    /**
     * @param  string  $native
     * @return PhoneNumberValueObject
     */
    public static function fromNative(mixed $native): PhoneNumberValueObject
    {
        return parent::make($native, 'RU');
    }

    public function toNative(): string
    {
        return parent::getRawNumber();
    }

    public function toDisplayValue(): string
    {
        return parent::formatForCountry('RU');
    }

    public function toCleanNative(): string
    {
        return trim(ltrim($this->toNative(), '+'));
    }

    public function __toString(): string
    {
        return $this->toNative();
    }
}
