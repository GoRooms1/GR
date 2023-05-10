<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Domain\Address\Models\Address;
use Domain\PageDescription\Models\PageDescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Str;
use Support\DataProcessing\Traits\CustomStr;

class PageDescriptionController extends Controller
{
    public function index(Request $request)
    {
        $descriptions = PageDescription::whereNull('model_id');
        $descriptions->where('type', '!=', 'undefined');

        if ($type = $request->get('type')) {
            $descriptions = $descriptions->where('type', $type);
        }

        if ($city = $request->get('city')) {
            $descriptions = $descriptions->where('url', 'like', '%/'.CustomStr::getCustomSlug($city).'%');
        }

        if ($area = $request->get('area')) {
            $descriptions = $descriptions->where('url', 'like', '%/area-'.CustomStr::getCustomSlug($area).'%');
        }

        if ($district = $request->get('district')) {
            $descriptions = $descriptions->where('url', 'like', '%/district-'.CustomStr::getCustomSlug($district).'%');
        }

        if ($street = $request->get('street')) {
            $descriptions = $descriptions->where('url', 'like', '%/street-'.CustomStr::getCustomSlug($street).'%');
        }

        if ($metro = $request->get('metro')) {
            $descriptions = $descriptions->where('url', 'like', '%/metro-'.CustomStr::getCustomSlug($metro).'%');
        }       
        
        $descriptions = $descriptions->paginate(15);        
        $cities = Address::pluck('city')->unique();

        return view('admin.descriptions.index', compact('descriptions', 'cities'));
    }

    public function edit(PageDescription $description)
    {
        return view('admin.descriptions.edit', compact('description'));
    }

    public function create(): View
    {
        $description = new PageDescription();
        return view('admin.descriptions.create', compact('description'));
    }

    public function store(Request $request): RedirectResponse
    {
        $description = new PageDescription();

        return $this->save($request, $description);
    }

    private function save(Request $request, PageDescription $description): RedirectResponse
    {
        $data = $request->validate([
            'url' => ['required', 'string', 'unique:page_descriptions,url'.($description->id ? ','.$description->id : '')],
            'title' => ['required', 'string'],
            'h1' => ['required', 'string'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);
        if (substr($data['url'], -1) == '/' && $data['url'] != '/') {
            $data['url'] = substr($data['url'], 0, -1);
        }
        $description->fill($data);
        $description->save();

        return redirect()->route('admin.descriptions.index');
    }

    public function update(Request $request, PageDescription $description): RedirectResponse
    {
        return $this->save($request, $description);
    }

    public function destroy(PageDescription $description): RedirectResponse
    {
        $description->delete();

        return redirect()->back();
    }
}
