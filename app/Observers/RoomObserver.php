<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use App\Models\Room;
use App\Models\Hotel;

class RoomObserver
{

  //TODO: После первой созданной комнаты, падает на модерацию.
  //TODO: После того как будут на модерации все комнаты, отель заново на модерацию
  /**
   * Handle the room "created" event.
   * Сбрасывает о том что недавно выбрали тип.
   * При удалении всех комнат будет выбор типа фонда в отеле
   * При создании самой первой комнаты, отель падает на модерацию
   *
   * @param Room $room
   * @return void
   */
  public function created(Room $room): void
  {
    if (auth()->check()) {
      Cache::flush();
      $hotel = $room->hotel;

      if (!auth()->user()->is_moderate && !auth()->user()->is_admin ) {

        $roomsModeration = Room::where('moderate', true)
          ->whereHas('hotel', function ($q) use($hotel) {
            $q->where('id', $hotel->id);
          })->count();

        // Если все комнаты на модерацию упали, то отель на модерацию
        if ($hotel->rooms()->count() === $roomsModeration ) {
          $hotel->moderate = true;
        }
      }

      // При создании одной комнаты запрет отельеру редактировать поля (Один раз после самой первой созданной комнаты)
      if ($hotel->old_moderate === false) {
        $hotel->old_moderate = true;

        $hotel->moderate = true;
      }

      // При создании комнаты, можно будет заново выбирать тип отеля ко комнатам
      if ($hotel->checked_type_fond === true) {
        $hotel->checked_type_fond = false;
      }
      $hotel->save();
    }


  }

  /**
   * Handle the room "updated" event.
   *
   * @param Room $room
   * @return void
   */
  public function updated(Room $room): void
  {
    if (auth()->check()) {
      Cache::flush();

      $hotel = $room->hotel;

      $this->moderate_hotel($hotel);
    }
  }

  /**
   * Handle the room "deleted" event.
   *
   * @param Room $room
   * @return void
   */
  public function deleted(Room $room): void
  {
    Cache::flush();
    $hotel = $room->hotel;
    if ($hotel->rooms()->count() === 0) {
      $hotel->type_fond = null;
      $hotel->checked_type_fond = false;

      if (!auth()->user()->is_moderate && !auth()->user()->is_admin) {
        $hotel->moderate = true;
      }

      $hotel->categories()->delete();
      $hotel->save();
    }

    if (auth()->check()) {

      $this->moderate_hotel($hotel);
    }
  }

  /**
   * Handle the room "restored" event.
   *
   * @param Room $room
   * @return void
   */
  public function restored(Room $room): void
  {
    //
  }

  /**
   * Handle the room "force deleted" event.
   *
   * @param Room $room
   * @return void
   */
  public function forceDeleted(Room $room): void
  {
    //
  }

  /**
   * @param Hotel $hotel
   */
  private function moderate_hotel (Hotel $hotel): void
  {
    if (!auth()->user()->is_moderate && !auth()->user()->is_admin) {

      $roomsModeration = Room::where('moderate', true)->whereHas('hotel', function ($q) use ($hotel) {
          $q->where('id', $hotel->id);
        })->count();

      // Если все комнаты на модерацию упали, то отель на модерацию
      if ($hotel->rooms()->count() === $roomsModeration) {
        $hotel->moderate = true;
      }
    }

    $hotel->save();
  }
}
