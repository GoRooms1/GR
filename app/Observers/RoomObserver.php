<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Observers;

use App\Models\Room;

class RoomObserver
{
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
    $hotel = $room->hotel;

    if ($hotel->moderate === false && $hotel->checked_type_fond && $hotel->rooms()->count() === 1) {
      $hotel->moderate = true;
    }

    $hotel->checked_type_fond = false;
    $hotel->old_moderate = true;

    $hotel->save();
  }

  /**
   * Handle the room "updated" event.
   *
   * @param Room $room
   * @return void
   */
  public function updated(Room $room): void
  {
    //
  }

  /**
   * Handle the room "deleted" event.
   *
   * @param Room $room
   * @return void
   */
  public function deleted(Room $room): void
  {
    $hotel = $room->hotel;
    if ($hotel->rooms()->count() === 0) {
      $hotel->type_fond = null;
      $hotel->checked_type_fond = false;

      $hotel->categories()->delete();
      $hotel->save();
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
}
