<?php
/*
 * Copyright (c) 2021.
 *  This code is the property of the Fulliton developer.
 *  Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Moderator;

use App\Helpers\Json;
use App\Http\Controllers\Controller;
use App\Http\Requests\LK\RoomRequest;
use Domain\Attribute\Model\AttributeCategory;
use Domain\Hotel\Models\Hotel;
use Domain\Room\Models\Cost;
use Domain\Room\Models\CostType;
use Domain\Room\Models\Period;
use Domain\Room\Models\Room;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function edit(int $id)
    {
        $hotel = Hotel::findOrFail($id);
        $rooms = $hotel->rooms;

        $costTypes = CostType::all();
        $attribute_categories = AttributeCategory::with(['attributes' => function ($q) {
            $q->whereModel(Room::class)->get();
        }])
          ->get()->sortByDesc(function ($category, $key) {
              return count($category->attributes);
          });

        if ($hotel->type_fond === Hotel::ROOMS_TYPE) {
            return view('moderator.room.edit-rooms', compact('rooms', 'hotel', 'costTypes', 'attribute_categories'));
        }

        if ($hotel->type_fond === Hotel::CATEGORIES_TYPE) {
            return view('moderator.room.edit-categories', compact('rooms', 'hotel', 'costTypes', 'attribute_categories'));
        }

        if ($hotel->rooms()->count() < 1) {
            return view('moderator.room.zero-rooms', compact('hotel'));
        }

        return redirect()->route('index');
    }

    public function update(RoomRequest $request): JsonResponse
    {
        $hotel = Hotel::whereHas('rooms', function ($q) use ($request) {
            $q->where('id', $request->get('id'));
        })->firstOrFail();
        $room = Room::find($request->get('id'));

        if ($hotel->type_fond === Hotel::ROOMS_TYPE) {
            $room = $this->saveDataTypeRoom($request->all(), $room);
        }

        $room->category()->associate($request->get('category'));       
        $costs = collect();

        foreach ($request->get('types') as $type) {
            $period = Period::find($type['data']);
            $samePeriods = Period::where('cost_type_id','=', $period->cost_type_id)->pluck('id');
            $cost = Cost::whereIn('period_id', $samePeriods)->where('room_id', $room->id)->first();
            
            if ($cost) {
                $cost->value = $type['value'];
                $cost->period()->associate($type['data']);
                $cost->save();
                $costs->push($cost);
                continue;
            }

            $cost = new Cost();
            $cost->value = $type['value'];
            $cost->period()->associate($type['data']);
            $cost->room()->associate($room->id);
            $cost->save();
            $costs->push($cost);
        }

        $room->save();

        return response()->json(['success' => true, 'room' => $room, 'category' => $room->category, 'costs' => $costs]);
    }

    /**
     * Save data if hotel has type Room
     *
     * @param    $data
     * @param  \Domain\Room\Models\Room  $room
     * @return Room
     */
    private function saveDataTypeRoom($data, Room $room): Room
    {
        $room->name = $data['name'];
        $room->order = $data['order'];
        $room->number = $data['number'];

        return $room;
    }

    /**
     * Delete Room
     *
     * @throws Exception
     */
    public function delete(int $id): JsonResponse
    {
        $room = Room::findOrFail($id);
        $status = $room->delete();

        //    TODO: deleting image;
        return response()->json(['success' => $status]);
    }

    /**
     * Return all attributes in room
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function getAttributes(int $id): JsonResponse
    {
        $room = Room::findOrFail($id);

        return response()->json(['attrs' => $room->attrs]);
    }

    /**
     * Save checked attributes in room
     *
     * @param  int  $id
     * @param  Request  $request
     * @return JsonResponse
     */
    public function putAttributes(int $id, Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|exists:attributes,id',
        ]);

        $room = Room::findOrFail($id);

        $room->attrs()->sync($request->get('ids'));
        $room->save();

        return response()->json(['success' => true, 'room' => $room]);
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     */
    public function published(int $id): JsonResponse
    {
        $room = Room::find($id);
        $room->update(['moderate' => false]);

        return Json::good(['moderate' => false]);
    }
}
