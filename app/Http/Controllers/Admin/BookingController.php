<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index ()
  {
    $bookings = Booking::with(['room', 'room.hotel'])->orderByDesc('book_number')->get();

    return view('admin.bookings.index', compact('bookings'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create ()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   *
   * @return Response
   */
  public function store (Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   *
   * @return Response
   */
  public function show (int $id)
  {
    $booking = Booking::findOrFail($id);
    $booking->on_show = true;
    $booking->save();
    return view('admin.bookings.show', compact('booking'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   *
   * @return Response
   */
  public function edit ($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int     $id
   *
   * @return Response
   */
  public function update (Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   *
   * @return Response
   */
  public function destroy ($id)
  {
    //
  }
}
