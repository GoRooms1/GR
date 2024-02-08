<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class SettingsController extends Controller
{
    public function index(): Response | ResponseFactory
    {       
        return Inertia::render('Client/Settings');
    }
}
