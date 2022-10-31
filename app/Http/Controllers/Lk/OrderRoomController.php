<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use Domain\Hotel\Models\Hotel;
use Domain\Hotel\Scopes\ModerationScope;
use Domain\Room\Models\Room;
use Domain\Room\Scopes\RoomModerationScope;
use Illuminate\Http\JsonResponse;

class OrderRoomController extends Controller
{
    public function upOrder(int $id): JsonResponse
    {
        $room = Room::withoutGlobalScope(RoomModerationScope::class)->findOrFail($id);

        $oldOrder = $room->order;

        $hotel = Hotel::withoutGlobalScope(ModerationScope::class)->find($room->hotel_id);

        $upperRoom = Room::withoutGlobalScope(RoomModerationScope::class)->where('order', '<', $oldOrder)
          ->whereHas('hotel', function ($q) use ($hotel) {
              $q->withoutGlobalScope(ModerationScope::class)->whereId($hotel->id);
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
                'success' => true,
            ]);
        }

        return response()->json([
            $room,
            'success' => false,
        ]);
    }

    public function downOrder(int $id): JsonResponse
    {
        $room = Room::withoutGlobalScope(RoomModerationScope::class)->findOrFail($id);

        $oldOrder = $room->order;

        $hotel = Hotel::withoutGlobalScope(ModerationScope::class)->find($room->hotel_id);

        $upperRoom = Room::withoutGlobalScope(RoomModerationScope::class)->where('order', '>', $oldOrder)
          ->whereHas('hotel', function ($q) use ($hotel) {
              $q->withoutGlobalScope(ModerationScope::class)->whereId($hotel->id);
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
                'success' => true,
            ]);
        }

        return response()->json([
            $room,
            'success' => false,
        ]);
    }
}
