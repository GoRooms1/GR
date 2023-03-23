<?php
declare(strict_types=1);

namespace Utils\PHPStan;

final class DeterminationBasedOnSuffix implements ControllerDetermination
{
    public function __construct(
        private readonly string $suffix = 'Controller'
    )
    {
    }

    public function isController(string $classReflection): bool
    {
        return str_ends_with($classReflection, $this->suffix) || strpos($classReflection, $this->suffix . 's');
    }
}