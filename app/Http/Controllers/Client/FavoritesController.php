<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\User;
use Domain\Room\Actions\ToggleFavoriteRoomAction;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FavoritesController extends Controller
{
    public function index(): Response | ResponseFactory
    {       
        return Inertia::render('Client/Favorites');
    }

    public function toggle(Request $request, int $id) 
    {        
        ToggleFavoriteRoomAction::run($id);
        return Redirect::back();
    }

    public function deleteAll(Request $request) 
    {
        if (auth()->check()) {
            $user = User::find(auth()->id());
            $user->favorites()->detach();
            session()->put('favorites', collect());
        }
        
        return Redirect::back();
    }
}
