<?php /** @noinspection ALL */

/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use App\User;
use Exception;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\LK\StaffRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StaffController extends Controller
{

  /**
   * All Users in Hotel
   *
   * @return Application|Factory|View
   * @noinspection PhpVariableNamingConventionInspection
   */
  public function index ()
  {
    $user = User::find(auth()->id());
    $hotel = $user->hotel;

    if ($hotel->users()->count() === 0) {
      $hotel->users()->attach($user->id);
    }

    /**
     * Length general users
     *
     * @var int $userGeneralCount
     */
    $userGeneralCount = $hotel->users()->wherePivot('hotel_position', User::POSITION_GENERAL)->count();

    /**
     * Length staff users
     *
     * @var int $userStaffCount
     */
    $userStaffCount = $hotel->users()->wherePivot('hotel_position', User::POSITION_STAFF)->count();

    /**
     * All users in hotel
     *
     * @var User[] $users
     */
    $users = $hotel->users()->withPivot(['hotel_position'])->get();
    return view('lk.staff.index', compact('users', 'userGeneralCount', 'userStaffCount'));
  }

  /**
   * Delete user in system
   *
   * @param int $id
   *
   * @return RedirectResponse
   */
  public function remove (int $id): RedirectResponse
  {
    try {
//      TODO: Если удаляют юзеров который самый клавный, то меняем главного на первого general
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
   *
   * @return RedirectResponse
   */
  public function create (StaffRequest $request): RedirectResponse
  {
    $user = new User($request->all());

    $user->password = Hash::make($request->get('password'));
    $user->is_admin = false;
    $user->is_moderate = false;
    $user->save();

    if (isset(auth()->user()->hotel)) {
      $hotel = auth()->user()->hotel;
      $hotel->users()->attach($user->id, ['hotel_position' => $request->get('hotel_position')]);
    }


    return back()->with('success', 'Пользователь успешно создан');
  }

  /**
   * Update user info
   *
   * @param StaffRequest $request
   * @param int          $id
   *
   * @return RedirectResponse|void
   */
  public function update (StaffRequest $request, int $id)
  {
    try {
      $user = User::findOrFail($id);

      $user->update($request->except('password'));
//      If user writen password, update )
      if ($request->has('password')) {
        if ($request->get('password') !== '') {
          $user->password = Hash::make($request->get('password'));
        }
      }

      $user->save();

      return back()->with('success', 'Пользователь обновлён');
    } catch (ModelNotFoundException $e) {
      return back()->with('error', 'Не удалось найти пользователя');
    }
  }

}