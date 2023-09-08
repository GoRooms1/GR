<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdBannerStoreRequest;
use App\Http\Requests\Admin\AdBannerUpdateRequest;
use Domain\AdBanner\DataTransferObjects\AdBannerData;
use Domain\AdBanner\Models\AdBanner;
use Domain\Address\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdBannerController extends Controller
{
    public function index(): View
    {
        $adBanners = AdBanner::all();

        return view('admin.ad_banners.index', compact('adBanners'));
    }

    public function create(): View
    {
        $cities = Address::distinct('city')->whereNotNull('city')->orderBy('city')->pluck('city');
        
        return view('admin.ad_banners.create', compact('cities'));
    }

    public function store(AdBannerStoreRequest $request): RedirectResponse
    {       
        $adBannerData = AdBannerData::fromRequest($request);
        $ad_banner = AdBanner::create($adBannerData->toArray());   

        return redirect()->route('admin.ad_banners.edit', $ad_banner)
            ->with([
                'success' => $ad_banner->id,
                'cities' => Address::distinct('city')->whereNotNull('city')->orderBy('city')->pluck('city'),
            ]);
    }

    public function edit(AdBanner $ad_banner): View
    {
        $cities = Address::distinct('city')->whereNotNull('city')->orderBy('city')->pluck('city');

        return view('admin.ad_banners.edit', compact('ad_banner', 'cities'));
    }

    public function update(AdBannerUpdateRequest $request, AdBanner $ad_banner): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $adBannerData = AdBannerData::fromRequest($request);        
        $ad_banner->update($adBannerData->toArray());        
        $cities = Address::distinct('city')->whereNotNull('city')->orderBy('city')->pluck('city');

        return view('admin.ad_banners.edit', compact('ad_banner', 'cities'));
    }

    public function destroy(AdBanner $ad_banner): RedirectResponse
    {
        $ad_banner->delete();

        return redirect()->route('admin.ad_banners.index');
    }
}
