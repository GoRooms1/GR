<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Json;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Domain\AdBanner\DataTransferObjects\AdBannerSimpleData;
use Domain\AdBanner\Models\AdBanner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\LaravelData\DataCollection;

class AdBannerController extends Controller
{
    public function getBanners(Request $request): JsonResponse
    {       
        $num = intval($request->get('num', 1));
        $city = strval($request->get('city'));
        $pageType = $request->get('page_type');
        $pageTypeColumn = null;
        $exclude = $request->session()->get('last_ad', []);
        
        if ($city == 'Москва и МО') 
            $city = 'Москва';

        switch ($pageType) {
            case 'hotels': 
                $pageTypeColumn = 'is_show_on_hotels';
                break;
            
            case 'hotel': 
                $pageTypeColumn = 'is_show_on_hotel';
                break;
            
            case 'rooms': 
                $pageTypeColumn = 'is_show_on_rooms';
                break;

            case 'hot': 
                $pageTypeColumn = 'is_show_on_hot';
                break;

            default:
                $pageTypeColumn = 'is_show_on_hotels';
                break;
        }
        
        $adBannersQuery = AdBanner::inRandomOrder()
            ->has('media')
            ->where(function($q) {
                $q->where('is_show_always', true)
                    ->orWhere(function ($q) {
                        $q->where('show_from', '<=', Carbon::now()->format('Y-m-d'))
                            ->where('show_to', '>=', Carbon::now()->format('Y-m-d'));
                    });
            })
            ->where($pageTypeColumn, true)
            ->where(function($q) use ($city) {
                $q->whereNull('cities')
                    ->orWhereRaw("JSON_SEARCH(`cities`, 'one', '".$city."', NULL, '$[*]') IS NOT NULL");
            });

        $countQuery = clone $adBannersQuery;

        if ($countQuery->whereNotIn('id', $exclude)->count() >= $num)
            $adBannersQuery = $adBannersQuery->whereNotIn('id', $exclude);

        $adBanners = $adBannersQuery->get();

        $adBanners = $adBanners->random($adBanners->count() < $num ? $adBanners->count() : $num);
        session()->put('last_ad', $adBanners->pluck('id'));
        
        if ($num > 1 && $adBanners->count() < $num)
        {
            $banner = $adBanners->first();
            
            while ($adBanners->count() < $num) {
                $adBanners->push($banner);
            }
            
        }

        return Json::good(['ad_banners' => new DataCollection(AdBannerSimpleData::class, $adBanners)]);
    }
}
