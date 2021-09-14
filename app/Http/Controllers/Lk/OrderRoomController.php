<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use App\Models\Room;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class OrderRoomController extends Controller
{

  public function upOrder(int $id): JsonResponse
  {
    $room = Room::findOrFail($id);

    $oldOrder = $room->order;

    $hotel = $room->hotel;

    $upperRoom = Room::where('order', '<', $oldOrder)
      ->whereHas('hotel', function ($q) use ($hotel) {
        $q->whereId($hotel->id);
      })
      ->orderByDesc('order')
      ->first();

    if ($upperRoom) {
      $order = $upperRoom->order;
      $upperRoom->order = $oldOrder;
      $upperRoom->save();

      $room->order = $order;
      $room->save();
      return response()->json([
        $room,
        'success' => true
      ]);
    }
    return response()->json([
      $room,
      'success' => false
    ]);

  }

  public function downOrder(int $id): JsonResponse
  {
    $room = Room::findOrFail($id);

    $oldOrder = $room->order;

    $hotel = $room->hotel;

    $upperRoom = Room::where('order', '>', $oldOrder)
      ->whereHas('hotel', function ($q) use ($hotel) {
        $q->whereId($hotel->id);
      })
      ->orderBy('order')
      ->first();

    if ($upperRoom) {
      $order = $upperRoom->order;
      $upperRoom->order = $oldOrder;
      $upperRoom->save();

      $room->order = $order;
      $room->save();
      return response()->json([
        $room,
        'success' => true
      ]);
    }
    return response()->json([
      $room,
      'success' => false
    ]);

  }
}