<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use App\Http\Requests\LK\StaffRequest;
use App\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StaffController extends Controller
{

  /**
   * @return Application|Factory|View
   */
  public function index()
  {
    $user = User::find(auth()->id());
    $hotel = $user->hotel;

    if ($hotel->users()->count() === 0) {
      $hotel->users()->attach($user->id);
    }

    $userGeneralCount = $hotel->users()
      ->wherePivot('hotel_position', User::POSITION_GENERAL)
      ->count();
    $userStaffCount = $hotel->users()
      ->wherePivot('hotel_position', User::POSITION_STAFF)
      ->count();

    $users = $hotel->users()->withPivot(['hotel_position'])->get();
    return view('lk.staff.index',
      compact(
        'users',
        'userGeneralCount',
        'userStaffCount'
      )
    );
  }

  public function remove(int $id): RedirectResponse
  {
    try {
      $user = User::findOrFail($id);

      if ($user->id !== auth()->id()) {
        $status = $user->forceDelete();
        if ($status) {
          return back()->with('success', 'Пользователь удалён');
        }
        return back()->with('error', 'Пользователь не удалён');
      }

      return back()->with('error', 'Пользователь не удалён. Так как Вы им являетесь');
    } catch (ModelNotFoundException $e) {
      return back()->with('error', 'Не удалось найти пользователя');
    } catch (Exception $e) {
      return back()->with('error', 'Не удалось удалить пользователя');
    }

  }

  /**
   * Create User in Hotel
   *
   * @param StaffRequest $request
   * @return RedirectResponse
   */
  public function create(StaffRequest $request): RedirectResponse
  {
    $user = new User($request->all());

    $user->password = Hash::make($request->get('password'));
    $user->is_admin = false;
    $user->is_moderate = false;
    $user->save();

    $hotel = auth()->user()->hotel;

    $hotel->users()->attach($user->id, ['hotel_position' => $request->get('hotel_position')]);

    return back()->with('success', 'Пользователь успешно создан');
  }

}