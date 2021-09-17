<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
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

    $users = $hotel->users()->withPivot(['hotel_position'])->get();
    return view('lk.staff.index', compact('users'));
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

}