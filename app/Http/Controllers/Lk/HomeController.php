<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(): View
    {
       return view('lk.index');
    }

    /**
     * Create Object
     *
     * @return \Inertia\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function start(): \Inertia\Response|\Symfony\Component\HttpFoundation\Response
    {
        if (auth()->check() && auth()->user()->is_admin) {
            return Inertia::location(route('admin.index'));
        }
        
        if (auth()->check() && auth()->user()->is_client) {
            return Inertia::location(route('client.settings'));
        }

        if (auth()->check() && auth()->user()->personal_hotel) {
            return Inertia::location(route('lk.index'));
        }       

        return Inertia::render('AuthExtranet/Register');
    }

    public function login(): \Inertia\Response
    {
       return Inertia::render('AuthExtranet/Login');
    }
}
