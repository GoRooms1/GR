<?php

declare(strict_types=1);

namespace Domain\Hotel\Scopes;

use Domain\Room\Scopes\RoomModerationScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Route;

final class ModerationScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (auth()->guest()) {
            //        Если не залогинен значит выводим только проверенные отели в которых есть комнаты
            $builder->withCount(['rooms' => function ($query) {
                $query->withoutGlobalScope(RoomModerationScope::class)->where('moderate', false);
            }])
                ->where('moderate', false)
                ->where('show', true)
                ->where('old_moderate', true)
                ->having('rooms_count', '>', 0);

            return;
        }
        if (Route::currentRouteNamed('lk.*')) {
            return;
        }
        if ($this->checkIfDefaultLoggedInUser()) {
//          Если залогинен значит выводим только проверенные отели в которых есть комнаты
            $builder
                ->withCount(['rooms' => function ($query) {
                    $query->withoutGlobalScope(RoomModerationScope::class)->where('moderate', false);
                }])
                ->having('rooms_count', '>', 0)
                ->where('moderate', false)
                ->where('old_moderate', true)
                ->where('show', true);
        } elseif ($this->checkIfModerator()) {
//          Если модератор то показываем отели только те которые уже заполнили и создавали ранее комнату
            $builder
                ->where('old_moderate', true);
        }
//        Если залогинен н админ то выводим просто всё
    }

    protected function checkIfModerator(): bool
    {
        return (auth()->user()?->is_moderate || auth()->user()?->is_admin) &&
            ! Route::currentRouteNamed('admin.*') &&
            ! Route::currentRouteNamed('moderator.*');
    }

    protected function checkIfDefaultLoggedInUser(): bool
    {
        return (! auth()->user()?->is_admin && ! auth()->user()?->is_moderate) &&
        ! Route::currentRouteNamed('lk.*') &&
        ! Route::currentRouteNamed('moderator.*') &&
        ! Route::currentRouteNamed('api.*') &&
        ! Route::currentRouteNamed('admin.*');
    }
}
