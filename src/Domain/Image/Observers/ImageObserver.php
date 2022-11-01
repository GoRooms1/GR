<?php

declare(strict_types=1);

namespace Domain\Image\Observers;

use Domain\Image\Models\Image;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

/**
 * Saved with new data default
 */
final class ImageObserver
{
    /**
     * Handle the image "created" event.
     *
     * @param  Image  $image
     * @return void
     */
    public function created(Image $image): void
    {
//    Image::beforeSave($image);
    }

    /**
     * Handle the image "updated" event.
     *
     * @param  Image  $image
     * @return void
     */
    public function updated(Image $image): void
    {
//    Image::beforeSave($image);
    }

    /**
     * Handle the image "deleted" event.
     *
     * @param  \Domain\Image\Models\Image  $image
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
                if ($other_image) {
                    $other_image->default = 1;
                    $other_image->save();
                }
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
            }
        }
        /** @var string $path */
        $path = $image->getRawOriginal('path');
        File::delete($path);
    }

    /**
     * Handle the image "restored" event.
     *
     * @param  Image  $image
     * @return void
     */
    public function restored(Image $image): void
    {
        //
    }

    /**
     * Handle the image "force deleted" event.
     *
     * @param  \Domain\Image\Models\Image  $image
     * @return void
     */
    public function forceDeleted(Image $image): void
    {
        //
    }
}
