<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageDescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageDescriptionController extends Controller
{
    public function index()
    {
        return view('admin.descriptions.index', [
            'descriptions' => PageDescription::whereNull('model_id')->paginate(15)
        ]);
    }

    public function edit(PageDescription $description)
    {
        return view('admin.descriptions.edit', compact('description'));
    }

    public function create(): View
    {
        return view('admin.descriptions.create');
    }

    private function save(Request $request, PageDescription $description): RedirectResponse
    {
        $data = $request->validate([
            'url' => ['required', 'string', 'unique:page_descriptions,url'.($description->id ? ','.$description->id : '')],
            'title' => ['required', 'string'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);
        if (substr($data['url'], -1) == '/' && $data['url'] != '/') {
            $data['url'] = substr($data['url'],0,-1);
        }
        $description->fill($data);
        $description->save();
        return redirect()->route('admin.descriptions.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $description = new PageDescription();
        return $this->save($request, $description);
    }

    public function update(Request $request, PageDescription $description): RedirectResponse
    {
        return $this->save($request, $description);
    }

    public function destroy(PageDescription $description): RedirectResponse
    {
        $description->delete();
        return redirect()->route('admin.descriptions.index');
    }
}
