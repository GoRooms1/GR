<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use Exception;
use App\Models\Room;
use App\Models\Cost;
use App\Models\Hotel;
use App\Models\CostType;
use Illuminate\View\View;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

/**
 * Edit Room in Hotel user
 */
class RoomController extends Controller
{
  use UploadImage;

  /**
   * Edit Page.
   * Show edit page or Page checked type fond
   *
   * @return View
   */
  public function edit(): View
  {
    $hotel = Auth::user()->hotel;
//    If Hotel don`t have type and zero rooms
    if (!$hotel->checked_type_fond && $hotel->rooms()->count() < 1) {
      return view('lk.room.fond', compact('hotel'));
    }

    $rooms = $hotel->rooms()->get();
    $costTypes = CostType::all();
    return view('lk.room.edit', compact('hotel', 'rooms', 'costTypes'));
  }

  /**
   * Method Update Type fond in Hotel
   *
   * @param Request $request
   *
   * @return RedirectResponse
   */
  public function fondUpdate(Request $request): RedirectResponse
  {
    $TYPES_FOND = Hotel::TYPES_FOND;
    $request->validate([
      'fond' => 'required|in:' . implode(',', $TYPES_FOND)
    ]);
    $hotel = Auth::user()->hotel;

    $hotel->type_fond = $request->get('fond');
    $hotel->checked_type_fond = true;
    $hotel->save();

    return redirect()->route('lk.room.edit')->with('success', 'Тип Фонда обновлён');
  }

  /**
   * @throws Exception
   */
  public function saveRoom(Request $request): JsonResponse
  {
    $request->validate([
      'id' => 'sometimes|required|exists:rooms,id'
    ]);

    $hotel = Hotel::whereHas('rooms', function ($q) use($request) {
      $q->where('id', $request->get('id'));
    })->first();

    if (!$hotel) {
      throw new Exception('Не найдет отель для комнаты');
    }

    $request->validate([
      'order' => 'sometimes|required|unique:rooms,order,'. $request->get('id') .',id,hotel_id,' . $hotel->id,
      'number' => 'sometimes|required',
      'name' => 'sometimes|required',
      'category' => 'sometimes|required|exists:categories,id',
      'types' => 'sometimes|required|array',
      'types.*.id' =>'required|exists:cost_types,id',
      'types.*.value' =>'required',
      'types.*.data' =>'required|exists:periods,id',
    ]);

    $room = Room::find($request->id);
    $room->name = $request->get('name');
    $room->order = $request->get('order');
    $room->number = $request->get('number');
    $room->category()->associate($request->get('category'));
    $room->moderate = true;

    $room->costs()->delete();

    foreach ($request->get('types') as $type) {
      $cost = new Cost();
      $cost->value = $type['value'];
      $cost->period()->associate($type['data']);
      $cost->room()->associate($room->id);
      $cost->save();
    }

    $room->save();

    return response()->json(['success' => true, 'room' => $room]);
  }

  /**
   * @throws Exception
   */
  public function deleteRoom (int $id): JsonResponse
  {
    $room = Room::findOrFail($id);
    $status = $room->delete();
//    TODO: deleting image;
    return response()->json(['success' => $status]);
  }

  public function create (Request $request): JsonResponse
  {

    $room = new Room();
    $room->hotel()->associate($request->get('hotel_id'));
    $status = $room->save();

    return response()->json(['success' => $status, 'room' => $room ]);
  }
}