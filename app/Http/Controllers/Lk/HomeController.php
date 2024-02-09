<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use Domain\Hotel\Models\HotelType;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
       return view('lk.index');
    }

    /**
     * Create Object
     *
     * @return RedirectResponse|View
     */
    public function start()
    {
        if (auth()->check() && auth()->user()->is_client) {
            return redirect()->route('client.settings');
        }

        if (auth()->check() && auth()->user()->personal_hotel) {
            return redirect()->route('lk.index');
        }

        $types = HotelType::all();

        return view('lk.start', compact('types'));
    }
}
