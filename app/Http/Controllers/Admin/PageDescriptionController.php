<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\PageDescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Str;

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
            $descriptions = $descriptions->where('url', 'like', '%/'.Str::slug($city).'%');
        }

        if ($area = $request->get('area')) {
            $descriptions = $descriptions->where('url', 'like', '%/area-'.Str::slug($area).'%');
        }

        if ($district = $request->get('district')) {
            $descriptions = $descriptions->where('url', 'like', '%/district-'.Str::slug($district).'%');
        }

        if ($street = $request->get('street')) {
            $descriptions = $descriptions->where('url', 'like', '%/street-'.Str::slug($street).'%');
        }

        if ($metro = $request->get('metro')) {
            $descriptions = $descriptions->where('url', 'like', '%/metro-'.Str::slug($metro).'%');
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
        return view('admin.descriptions.create');
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
