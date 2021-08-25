<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

/**
 * Edit Room in Hotel user
 */
class RoomController extends Controller
{

  public function edit ()
  {
    $hotel = Auth::user()->hotel;
    if ($hotel->rooms()->count() < 1 && !$hotel->checked_type_fond) {
      return view('lk.room.fond', compact('hotel'));
    }
    return view('lk.room.edit');
  }

  public function fondUpdate (Request $request): RedirectResponse
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