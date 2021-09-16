<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Observers;

use App\Models\Room;
use App\Models\Hotel;
use App\Models\Category;

/**
 * Saved with new data default
 */
class CategoryObserver
{
  /**
   * Handle the Category "created" event.
   *
   * @param Category $Category
   * @return void
   */
  public function created(Category $Category): void
  {

  }

  /**
   * Handle the Category "updated" event.
   *
   * @param Category $category
   * @return void
   */
  public function updated(Category $category): void
  {

  }

  /**
   * Handle the Category "deleting" event.
   *
   * @param Category $category
   * @return void
   */
  public function deleting(Category $category): void
  {
    $rooms = $category->rooms()->get();

    if (isset($category->value)) {
      foreach ($rooms as $room) {
        $room->delete();
      }
    }
  }

  /**
   * Handle the Category "deleted" event.
   *
   * @param Category $category
   * @return void
   */
  public function deleted(Category $category): void
  {

  }

  /**
   * Handle the Category "restored" event.
   *
   * @param Category $category
   * @return void
   */
  public function restored(Category $category): void
  {
    //
  }

  /**
   * Handle the Category "force deleted" event.
   *
   * @param Category $category
   * @return void
   */
  public function forceDeleted(Category $category): void
  {
    //
  }
}
