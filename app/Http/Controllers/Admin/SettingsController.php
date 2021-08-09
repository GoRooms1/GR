<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        return view('admin.settings.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $all = $request->all();

        foreach ($all AS $option => $value) {
            \Cache::forget('setting.'.$option);
            Settings::updateOrCreate(['option' => $option], ['option' => $option, 'value' => $value]);
        }

        return redirect()->route('admin.settings.index');
    }

    public function storeRobot(Request $request): RedirectResponse
    {
        $robot_content = $request->get('content', '');
        file_put_contents(public_path('robots.txt'), $robot_content);

        return redirect()->route('admin.settings.index');
    }

    public function clearCache(): RedirectResponse
    {
        Artisan::call('optimize:clear');
        return back();
    }

    public function seo(): View
    {
        return view('admin.settings.seo', [
            'pages' => Settings::where('option', 'LIKE', 'seo_%')->get()
        ]);
    }

    public function seoEdit($id): View
    {
        return view('admin.settings.seoEdit', [
            'page' => Settings::find($id)
        ]);
    }

    public function seoUpdate($id): RedirectResponse
    {
        Settings::find($id)->update([
            'value' => \request()->value,
        ]);
        Artisan::call('optimize:clear');
        return redirect()->route('admin.settings.seo');
    }
}
