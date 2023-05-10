<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use App\Http\Requests\LK\CategoryRequest;
use Domain\Category\DataTransferObjects\CategoryData;
use Domain\Category\Models\Category;
use Domain\Hotel\Models\Hotel;
use Domain\Room\DataTransferObjects\RoomData;
use Domain\Room\Models\Room;
use Exception;
use Illuminate\Http\JsonResponse;

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
                } elseif ($count > 0) {
                    $roomLastOrder = Room::whereHas('hotel', function ($q) use ($hotel) {
                        $q->whereId($hotel->id);
                    })
                      ->orderByDesc('order')
                      ->firstOrFail();

                    $room->order = $roomLastOrder->order + 1;
                }
                $room->save();                

                return response()->json([
                    'status' => 'success',
                    'category' => $category,
                    'room' => RoomData::fromModel($room)->except('hotel'),
                ]);
            }

            return response()->json([
                'status' => 'success',
                'category' => CategoryData::fromModel($category),
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
            'status' => (bool) $status,
            'reload' => $countRoomsInHotel <= 0,
        ]);
    }

    public function save($category, $data): bool
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
