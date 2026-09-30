<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use App\Repositories\LanguageRepository;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = LanguageRepository::getAll();
        Cache::forget('languages');
        return view("admin.languages.index", compact("languages"));
    }

    public function create()
    {
        Cache::forget('languages');
        return view("admin.languages.create");
    }
    public function store(LanguageRequest $request)
    {
        LanguageRepository::store($request);
        Cache::forget('languages');
        SettingsService::clearCache();
        return redirect()->route("languages.index");
    }
    public function edit($id)
    {
        $language = Language::findOrFail($id);
        Cache::forget('languages');
        return view('admin.languages.edit', compact('language'));
    }
    public function update(LanguageRequest $request, $id)
    {
        LanguageRepository::updateLanguage($request, $id);
        Cache::forget('languages');
        SettingsService::clearCache();
        return redirect()->route('languages.index')->with('success', 'Language updated successfully');
    }
    public function destroy($id)
    {
        LanguageRepository::deleteLanguage($id);
        Cache::forget('languages');
        SettingsService::clearCache();
        return redirect()->route('languages.index')->with('success', 'Language Delete Successfully');
    }
}
