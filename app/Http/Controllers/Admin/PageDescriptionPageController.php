<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Domain\PageDescription\Models\PageDescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageDescriptionPageController extends Controller
{
    public function index(Request $request)
    {
        $descriptions = PageDescription::whereNull('model_id');
        $descriptions->where('type', '=', 'undefined');

        $descriptions = $descriptions->paginate(15);

        return view('admin.descriptions-page.index', compact('descriptions'));
    }

    public function edit(int $id)
    {
        $description = PageDescription::findOrFail($id);

        return view('admin.descriptions-page.edit', compact('description'));
    }

    public function create(): View
    {
        return view('admin.descriptions-page.create');
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
        $description->type = 'undefined';
        $description->save();

        return redirect()->route('admin.descriptions-page.index');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $description = PageDescription::findOrFail($id);

        return $this->save($request, $description);
    }

    public function destroy(int $id): RedirectResponse
    {
        $description = PageDescription::findOrFail($id);
        $description->delete();

        return redirect()->back();
    }
}
