<?php

namespace App\Http\Controllers;

use App\Models\Booking;

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
}
