<?php

namespace App\Http\Controllers;

use Domain\Hotel\Actions\FilterHotelsAction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class FilterController extends Controller
{
    public function filter(Request $request)
    {
        dd(FilterHotelsAction::run($request->all()['hotels']));
        return Inertia::location(route('home'));
    }
}
