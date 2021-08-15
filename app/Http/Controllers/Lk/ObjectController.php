<?php

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\CostType;
use App\Models\Hotel;
use App\Models\HotelType;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ObjectController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function store(Request $request): RedirectResponse
  {
    $request->validate([
      'name' => 'required|string|min:0',
      'password' => 'string|min:3',
      'position' => 'required|string|min:3',
      'code' => 'required|string|min:3',
      'phone' => 'required|string',
      'email' => 'required|string',
      'hotel' => 'required|array',
      'hotel.name' => 'required|string',
      'hotel.type' => 'required|exists:hotel_types,id',
      'address' => 'required|string'
    ]);
    if (auth()->check()) {
      $request->validate([
        'email' => 'unique:users,email,' . auth()->id(),
      ]);
      $user = User::find(auth()->id());
      $user->update($request->all());
      $user->password = Hash::make($request->password);
      $user->save();
    } else {
      $request->validate([
        'email' => 'unique:users,email'
      ]);

      $user = new User($request->all());
      $user->password = Hash::make($request->password);
      $user->save();
      Auth::loginUsingId($user->id, true);
    }

    $hotel = new Hotel();
    $hotel->name = $request->get('hotel.name');
    $hotel->phone = $request->get('phone');
    $hotel->email = $request->get('email');

    $hotel->type()->associate($request->get('hotel.type'));
    $hotel->user()->associate($user->id);
    $hotel->save();
    $hotel->saveAddress($request->get('address', ''));
    return redirect()->route('lk.object.edit');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @return Application|Factory|View
   */
  public function edit()
  {
    $hotel = auth()->user()->hotel;
    $attributes = Attribute::where('model', Hotel::class)->orWhereNull('model')->get();
    $costTypes = CostType::orderBy('sort')->get();
    $hotelTypes = HotelType::orderBy('sort')->get();
    return view('lk.object.edit', compact('hotel', 'costTypes', 'attributes', 'hotelTypes'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @return Response
   */
  public function update(Request $request)
  {
    //
  }
}
