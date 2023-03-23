<?php
declare(strict_types=1);

namespace Utils\PHPStan;

interface ControllerDetermination
{
    public function isController(string $classReflection): bool;
}