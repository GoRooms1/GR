<?php

declare(strict_types=1);

namespace Parent\ValueObjects;

interface ValueObject
{
    /**
     * @return bool
     */
    public function isNull(): bool;

    /**
     * @param  ValueObject  $object
     * @return bool
     */
    public function isSame(ValueObject $object): bool;

    public static function fromNative(mixed $native): mixed;

    public function toNative(): mixed;
}
