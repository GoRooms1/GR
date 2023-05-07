<?php

declare(strict_types=1);

namespace Domain\Hotel\Scopes;

use Domain\Room\Scopes\RoomModerationScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Route;

final class HotelOrderingScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->orderBy('moderate', 'desc')->orderBy('created_at', 'desc');
    }
}
