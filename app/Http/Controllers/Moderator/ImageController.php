<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Moderator;

use App\Helpers\Json;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Traits\UploadImage;
use Illuminate\Http\JsonResponse;

/**
 * Image
 */
class ImageController extends Controller
{
    use UploadImage;

    /**
     * @param  Image  $image
     * @return JsonResponse
     */
    public function moderate(Image $image): JsonResponse
    {
        try {
            $image->moderate = false;
            $image->save();

            return Json::good(['image' => $image]);
        } catch (\Exception $exception) {
            return Json::bad(['error' => $exception->getMessage()]);
        }
    }
}
