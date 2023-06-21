<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Moderator;

use App\Helpers\Json;
use App\Http\Controllers\Controller;
use Domain\Image\Traits\UploadImage;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Image
 */
class ImageController extends Controller
{
    use UploadImage;

    /**
     * @param  Media $image
     * @return JsonResponse
     */
    public function moderate(Media $image): JsonResponse
    {
        try {
            $image->setCustomProperty('moderate', false);
            $image->save();

            return Json::good(['image' => $image]);
        } catch (\Exception $exception) {
            return Json::bad(['error' => $exception->getMessage()]);
        }
    }
}
