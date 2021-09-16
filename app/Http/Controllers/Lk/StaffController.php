<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use App\User;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{

  public function index ()
  {
    $user = User::find(auth()->id());
    $hotel = $user->hotel;

//    $hotel->users()->attach($user->id);

    $users = $hotel->users()->withPivot(['hotel_position'])->get();
//    dd($users);
    return view('lk.staff.index', compact('users'));
  }
}