<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Observers;

use App\Models\Image;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

/**
 * Saved with new data default
 */
class ImageObserver
{
  /**
   * Handle the image "created" event.
   *
   * @param Image $image
   * @return void
   */
  public function created(Image $image): void
  {
//    Image::beforeSave($image);
  }

  /**
   * Handle the image "updated" event.
   *
   * @param Image $image
   * @return void
   */
  public function updated(Image $image): void
  {
//    Image::beforeSave($image);
  }

  /**
   * Handle the image "deleted" event.
   *
   * @param Image $image
   * @return void
   */
  public function deleted(Image $image): void
  {
    if ($image->default) {
      $model_id = $image->model_id;
      $model_type = $image->model_type;
      try {
        $other_image = Image::where('model_id', $model_id)
          ->where('model_type', $model_type)
          ->whereNot('id', $image->id)
          ->first();
        $other_image->default = true;
        $other_image->save();
      } catch (Exception $exception) {
        if (Image::where('model_id', $model_id)->where('model_type', $model_type)->count() > 0) {
          Log::error($exception);
        }
      }
    }
    File::delete($image->getRawOriginal('path'));
  }

  /**
   * Handle the image "restored" event.
   *
   * @param Image $image
   * @return void
   */
  public function restored(Image $image): void
  {
    //
  }

  /**
   * Handle the image "force deleted" event.
   *
   * @param Image $image
   * @return void
   */
  public function forceDeleted(Image $image): void
  {
    //
  }
}
