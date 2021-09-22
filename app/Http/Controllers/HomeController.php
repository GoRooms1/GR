<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Hotel;
use App\Models\Page;
use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function index(Request $request): View
    {

        $city = session('city', 'null');
        $auth = auth()->check() ? auth()->id() : 'user';
        $hotels = Cache::remember('hotels_city.' . $auth . '.' . $city, 60*60*24*12, function () use ($city) {
            return Hotel::popular()->whereHas('address', function (Builder $builder) use($city) {
                $builder->where('city', $city);
            })->get();
        });
        $rooms = Cache::remember('rooms_city.' . $auth . '.' . $city, 60*60*24*12, function () use ($city) {
            return Room::with('hotel.ratings')->hot()->whereHas('hotel.address', function (Builder $builder) use($city) {
                $builder->where('city', $city);
            })->get();
        });
        $articles = Cache::remember('articles_home', 60*60*24*12, function() {
            return Article::orderBy('created_at', 'DESC')->limit(4)->get();
        });
        $pages = Page::all()->keyBy('slug');
        return view('home', compact('hotels', 'rooms', 'articles', 'pages'));
    }
}
