<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        $last_book_number = Booking::orderByDesc('id')->first()->book_number ?? '200100000';

        $last_year = (int) mb_substr($last_book_number, 0, 4);
        $year = (int) date('Y');

        if ($last_year === $year) {
            $current_number = (int) $last_book_number + 1;
        } else {
            $current_number = $year.'00001';
        }

        return (string) $current_number;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  Booking  $booking
     * @return Response
     */
    public function show(Booking $booking): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Booking  $booking
     * @return Response
     */
    public function edit(Booking $booking): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Booking  $booking
     * @return Response
     */
    public function update(Request $request, Booking $booking): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Booking  $booking
     * @return Response
     */
    public function destroy(Booking $booking): Response
    {
        //
    }
}
