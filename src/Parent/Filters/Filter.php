<?php

declare(strict_types=1);

namespace Parent\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

abstract class Filter
{
    protected readonly Stringable $value;

    /**
     * @param  string  $value
     */
    public function __construct(
        string $value
    ) {
        $this->value = Str::of($value);
    }

    abstract public function handle(Builder $builder, \Closure $next): Builder;
}
