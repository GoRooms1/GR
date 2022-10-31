<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Observers;

use Domain\Hotel\Models\Hotel;
use Domain\Hotel\Scopes\ModerationScope;
use Domain\Room\Models\Room;
use Domain\Room\Scopes\RoomModerationScope;
use Illuminate\Support\Facades\Cache;

class RoomObserver
{
    /**
     * Handle the room "created" event.
     * Сбрасывает о том что недавно выбрали тип.
     * При удалении всех комнат будет выбор типа фонда в отеле
     * При создании самой первой комнаты, отель падает на модерацию
     *
     * @param  \Domain\Room\Models\Room  $room
     * @return void
     */
    public function created(Room $room): void
    {
        Cache::flush();
        /** @var Hotel $hotel */
        $hotel = Hotel::withoutGlobalScope(ModerationScope::class)->findOrFail($room->hotel_id);

        // При создании одной комнаты запрет отельеру редактировать поля (Один раз после самой первой созданной комнаты)
        if ($hotel->old_moderate === false) {
            $hotel->old_moderate = true;
        }

        // При создании комнаты, можно будет заново выбирать тип отеля ко комнатам
        if ($hotel->checked_type_fond === true) {
            $hotel->checked_type_fond = false;
        }
        $hotel->save();

        $this->moderate_hotel($hotel);
    }

    /**
     * Handle the room "updated" event.
     *
     * @param  \Domain\Room\Models\Room  $room
     * @return void
     */
    public function updated(Room $room): void
    {
        Cache::flush();
        /** @var ?Hotel $hotel */
        $hotel = Hotel::withoutGlobalScope(ModerationScope::class)->find($room->hotel_id);
        if ($hotel) {
            $this->moderate_hotel($hotel);
        }
    }

    /**
     * Handle the room "deleted" event.
     *
     * @param  \Domain\Room\Models\Room  $room
     * @return void
     */
    public function deleted(Room $room): void
    {
        Cache::flush();
        /** @var Hotel $hotel */
        $hotel = Hotel::withoutGlobalScope(ModerationScope::class)->findOrFail($room->hotel_id);
        if ($hotel->rooms()->count() === 0) {
            $hotel->type_fond = null;
            $hotel->checked_type_fond = false;

            $hotel->categories()->delete();
            $hotel->save();
        }

//    if (Route::currentRouteNamed('lk.*')) {
        $this->moderate_hotel($hotel);
//    }
    }

    /**
     * Handle the room "restored" event.
     *
     * @param  \Domain\Room\Models\Room  $room
     * @return void
     */
    public function restored(Room $room): void
    {
        //
    }

    /**
     * Handle the room "force deleted" event.
     *
     * @param  \Domain\Room\Models\Room  $room
     * @return void
     */
    public function forceDeleted(Room $room): void
    {
        //
    }

    /**
     * Set show or hide hotel if zero rooms in publish
     *
     * @param  Hotel  $hotel
     */
    private function moderate_hotel(Hotel $hotel): void
    {
        $roomsModeration = Room::withoutGlobalScope(RoomModerationScope::class)
          ->where('moderate', false)
          ->whereHas('hotel', function ($q) use ($hotel) {
              $q->where('id', $hotel->id);
          })->count();

        // Если все комнаты на модерацию упали, то отель на модерацию
        if ($roomsModeration > 0) {
            $hotel->show = true;
        } else {
            $hotel->show = false;
        }

        $hotel->save();
    }
}
