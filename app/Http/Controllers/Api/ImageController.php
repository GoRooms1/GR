<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 *  Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Api;

use App\Helpers\Json;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function ordered(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:images,id',
        ]);

        $i = 1;
        $ids = $request->get('ids');
        foreach ($ids as $id) {
            $image = Image::findOrFail($id);
            $image->order = $i;
            $image->save();
            $i++;
        }

        return Json::good(['ids' => $ids]);
    }
}
