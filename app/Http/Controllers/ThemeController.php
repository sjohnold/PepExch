<?php

namespace App\Http\Controllers;

use App\Enums\Seting;
use App\Http\Requests\ThemeRequest;
use App\Repositories\SettingRepository;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;

class ThemeController extends Controller
{
    public function index()
    {
        $type = Seting::ThemeColor->value;
        $setting = SettingRepository::getByType($type);
        $themeData = $setting ? json_decode($setting->data, true) : [];
        return view('admin.appearance.theme.index', compact('themeData'));
    }

    public function update(ThemeRequest $request): RedirectResponse
    {
        $type = Seting::ThemeColor->value;
        $setting = SettingRepository::getByType($type);
        Artisan::call('optimize:clear');
        if ($setting) {
            SettingRepository::updateByRequest($setting, $request);
            SettingsService::clearCache();
            return redirect()->route('theme.index')->with('success', 'Theme updated successfully.');
        }
        return redirect()->route('theme.index')->with('error', 'Theme setting not found.');
    }
}
