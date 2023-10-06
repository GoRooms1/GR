<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use Domain\Page\Actions\AttachMetaAction;
use Domain\Page\Models\Page;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\PageDescription\Models\PageDescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $pages = Page::all();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PageRequest  $request
     * @return RedirectResponse
     */
    public function store(PageRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;
        $page = Page::create($validated);
        $page->save();

        $data = [];
        $data['title'] = $request->get('meta_title');
        $data['meta_description'] = $request->get('meta_description');
        $data['meta_keywords'] = $request->get('meta_keywords');
        $data['url'] = '/'.$page->slug;
        $data['h1'] = $request->get('title');
        $data['type'] = 'page';
        AttachMetaAction::run($page, PageDescriptionData::from($data));

        return redirect()->route('admin.pages.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Domain\Page\Models\Page  $page
     * @return View
     */
    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PageRequest  $request
     * @param  \Domain\Page\Models\Page  $page
     * @return RedirectResponse
     */
    public function update(PageRequest $request, Page $page): RedirectResponse
    {
        $validated = $request->validated();
        $page->update($validated);

        $data = [];
        $data['title'] = $request->get('meta_title');
        $data['meta_description'] = $request->get('meta_description');
        $data['meta_keywords'] = $request->get('meta_keywords');
        $data['url'] = '/'.$page->slug;
        $data['h1'] = $request->get('title');
        $data['type'] = 'page';
        AttachMetaAction::run($page, PageDescriptionData::from($data));

        return redirect()->route('admin.pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Domain\Page\Models\Page  $page
     * @return RedirectResponse
     */
    public function destroy(Page $page): RedirectResponse
    {
        $id = $page->id;
        $page->delete();
        $page->forceDelete();
        $pd = PageDescription::whereModelType(Page::class)->whereModelId($id)->first();
        $pd?->delete();

        return redirect()->route('admin.pages.index');
    }
}
