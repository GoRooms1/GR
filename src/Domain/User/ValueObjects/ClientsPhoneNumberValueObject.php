<?php

declare(strict_types=1);

namespace Domain\User\ValueObjects;

use Parent\ValueObjects\ValueObject;

/**
 * Class ClientsPhoneNumberValueObject
 */
final class ClientsPhoneNumberValueObject implements ValueObject
{
    protected string $value = '';
    public function __construct(string $value) {
        $this->value = $value;
    }
    
    public function isNull(): bool
    {
        return empty($this->value) ;
    }

    public function isSame(ValueObject $object): bool
    {
        return $this->toNative() === $object->toNative();
    }
    
    public static function fromNative(mixed $native): static
    {
        return new static($native);
    }    

    public function toDisplayValue(): string
    {
        $value = $this->toNative();

        if (str_starts_with($value, '+7') && strlen($value) === 12) {
            return sprintf("%s (%s) %s %s-%s",
                substr($value, 0, 2),
                substr($value, 2, 3),
                substr($value, 5, 3),
                substr($value, 8, 2),
                substr($value, 10, 2)
            );
        }

        return $value;
    }

    public function toNative(): string
    {
        return "+".trim(preg_replace("/[^0-9]/", "", $this->value));
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
