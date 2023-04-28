<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Carbon\Carbon;
use Domain\Address\Models\Address;
use Domain\Hotel\Models\Hotel;
use Domain\Page\Models\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Support\DataProcessing\Traits\CustomStr;

class SiteMapController extends Controller
{
    private $added_links = [];

    public function index()
    {
        $ttl = 60 * 60 * 24 * 7;
        $links = Cache::remember('sitemap.2g', $ttl, function () {
            $articles = Article::orderBy('created_at', 'DESC')->get();
            $hotels = Hotel::all();
            $pages = Page::all();
            $links = [];
            if ($link = $this->makeLink(route('hotels.index'))) {
                $links[] = $link;
            }
            foreach ($hotels as $hotel) {
                $links[] = $this->makeLink(route('hotels.show', $hotel), 'monthly', 0.8, $hotel->updated_at->format('Y-m-d'));
            }
            if ($link = $this->makeLink(route('articles.index'))) {
                $links[] = $link;
            }
            foreach ($articles as $article) {
                $links[] = $this->makeLink(route('articles.show', $article), 'monthly', 0.8, $article->updated_at->format('Y-m-d'));
            }
            foreach ($pages as $page) {
                $links[] = $this->makeLink(route('pages.show', $page), 'monthly', 0.8, $page->updated_at->format('Y-m-d'));
            }
            $addresses = Address::all();
            foreach ($addresses as $address) {
                $params = [
                    'city' => CustomStr::getCustomSlug($address->city),
                ];
                $links[] = $this->makeLink(route('search.address', $params), 'monthly', 0.8, $address->updated_at->format('Y-m-d'));
                $params = [
                    'city' => CustomStr::getCustomSlug($address->city),
                    'area' => 'area-'.CustomStr::getCustomSlug($address->city_area),
                ];
                $links[] = $this->makeLink(route('search.address', $params), 'monthly', 0.8, $address->updated_at->format('Y-m-d'));
                $params = [
                    'city' => CustomStr::getCustomSlug($address->city),
                    'area' => 'area-'.CustomStr::getCustomSlug($address->city_area),
                    'district' => 'district-'.CustomStr::getCustomSlug($address->city_district),
                ];
                $links[] = $this->makeLink(route('search.address', $params), 'monthly', 0.8, $address->updated_at->format('Y-m-d'));
                if ($address->hotel) {
                    foreach ($address->hotel->metros as $metro) {
                        $params = [
                            'city' => CustomStr::getCustomSlug($address->city),
                            'area' => 'metro-'.CustomStr::getCustomSlug($metro->name),
                        ];
                        $links[] = $this->makeLink(route('search.address', $params), 'monthly', 0.8, $address->hotel->updated_at->format('Y-m-d'));
                    }
                }
            }

            return array_filter($links, function ($item) {
                return ! is_null($item);
            });
        });
        $map = view('sitemap', compact('links'));

        return response($map)->header('Content-Type', 'application/xml');
    }

    private function makeLink($url, $changefreq = 'monthly', $priority = 0.8, $lastmod = null): ?object
    {
        if ($this->checkUrl($url)) {
            return null;
        }

        return (object) [
            'loc' => $url,
            'lastmod' => $lastmod ?? Carbon::now()->startOfMonth()->format('Y-m-d'),
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }

    private function checkUrl($url): bool
    {
        if (in_array($url, $this->added_links)) {
            return true;
        }
        $this->added_links[] = $url;
        $robots_path = public_path('robots.txt');
        if (! file_exists($robots_path)) {
            return false;
        }
        $robots_content = file_get_contents($robots_path);
        preg_match_all("/Disallow: (.*?)\s\n/imU", $robots_content, $matches);
        $robots = $matches[1];

        foreach ($robots as $item) {
            $item = str_replace('*', '.*', $item);
            $item = str_replace('+', '\+', $item);
            $item = str_replace('.', '\.', $item);
            $item = str_replace('/', '\/', $item);
            if (preg_match('/^'.$item.'/', $url)) {
                return true;
            }
        }

        return false;
    }
}
