<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use App\Models\Room;
use App\Models\Hotel;
use App\Models\CostType;
use Illuminate\View\View;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
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
}