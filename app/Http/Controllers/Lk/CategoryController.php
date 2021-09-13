<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use Exception;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\LK\CategoryRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
  public function update(CategoryRequest $request): JsonResponse
  {
    $category = Category::findOrFail($request->get('id'));

    if ($this->save($category, $request->all())) {
      return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error']);
  }

  public function create(CategoryRequest $request): JsonResponse
  {
    $category = new Category();

    if ($this->save($category, $request->all())) {
      if ($category->hotel->type_fond === Hotel::CATEGORIES_TYPE) {
        $room = new Room();
        $room->hotel()->associate($category->hotel->id);
        $room->category()->associate($category->id);
        $hotel = $category->hotel;

        $count = $hotel->rooms()->count();
        if ($count === 0) {
          $room->order = 1;
        } else if ($count > 0) {
          $room->order = $hotel->rooms()->get()->sortByDesc('order')->first()->order + 1;
        }
        $room->save();
        return response()->json([
          'status' => 'success',
          'category' => $category,
          'room' => $room
        ]);
      }
      return response()->json([
        'status' => 'success',
        'category' => $category
      ]);
    }

    return response()->json(['status' => 'error']);
  }

  /**
   * @throws Exception
   */
  public function delete(Category $category): JsonResponse
  {
    $countRoomsInHotel = $category->hotel->rooms()->count();
    $status = $category->delete();
    return response()->json([
      'status' => (boolean) $status,
      'reload' => $countRoomsInHotel <= 0
    ]);
  }

  public function save(&$category, $data): bool
  {
    try {
      $category->name = $data['name'];
      $category->value = $data['value'];

      if (isset($data['hotel_id'])) {
        $category->hotel()->associate($data['hotel_id']);
      }

      $category->save();

      return true;
    } catch (Exception $exception) {
      return false;
    }
  }
}
