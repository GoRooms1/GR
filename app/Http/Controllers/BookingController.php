<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Необходимо чтобы номер заказа был в формате "202100043", где сначала идет год, затем номер
     * Данная функция определяет следующий номер
     *
     * @return string
     */
    public static function defineNextBookNumber(): string
    {
        $last_book_number = Booking::orderby('id', 'desc')->first()->book_number ?? '200100000';
        $last_year = mb_substr($last_book_number, 0, 4);
        $last_number = mb_substr($last_book_number, 4, 5);
        $year = date("Y");

        if ($last_year != $year) {
            $current_number = intval($last_number) + 1;
        } else {
            $current_number = 1;
        }

        return $year.str_pad($current_number,5, '0', STR_PAD_LEFT);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
