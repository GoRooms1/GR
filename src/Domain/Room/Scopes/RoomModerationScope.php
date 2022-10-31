<?php

declare(strict_types=1);

namespace Domain\Room\Scopes;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Route;

final class RoomModerationScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        /** @var User $user */
        $user = auth()->user();
        if (auth()->guest()) {
            $builder->whereHas('hotel', function ($q) {
                $q->where('moderate', false)->where('show', true);
            })->where('moderate', false);

            return;
        }
        if ((! $user->is_admin && ! $user->is_moderate) &&
            ! Route::currentRouteNamed('lk.*') &&
            ! Route::currentRouteNamed('moderator.*') &&
            ! Route::currentRouteNamed('api.*') &&
            ! Route::currentRouteNamed('admin.*')
        ) {
            $builder->whereHas('hotel', function ($q) {
                $q->where('moderate', false)->where('show', true);
            })->where('moderate', false);
        }
    }
}
