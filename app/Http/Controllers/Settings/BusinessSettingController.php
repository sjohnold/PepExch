<?php

namespace App\Http\Controllers\Settings;

use App\Enums\Seting;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBusinessSettingsRequest;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class BusinessSettingController extends Controller
{
    public function index()
    {
        $businessSettings = SettingRepository::getAllBusinessSettings();

        $currencySetting       = $businessSettings->where('type', 'Currency')->first();
        $gstSetting            = $businessSettings->where('type', 'GST')->first();
        $taxSetting            = $businessSettings->where('type', 'Tax')->first();
        $addressSetting        = $businessSettings->where('type', 'Address')->first();
        $supportMailSetting    = $businessSettings->where('type', 'Support Mail')->first();
        $supportContactSetting = $businessSettings->where('type', 'Support Contact')->first();
        $footerTitleSetting    = $businessSettings->where('type', 'Footer Title')->first();


        return view('admin.settings.business.index', compact(
            'businessSettings',
            'currencySetting',
            'gstSetting',
            'taxSetting',
            'addressSetting',
            'supportMailSetting',
            'supportContactSetting',
            'footerTitleSetting'
        ));
    }

    public function update(UpdateBusinessSettingsRequest $request)
    {
        // Update in database first
        SettingRepository::updateBusinessSettings($request);
        // Update in .env
        if ($request->has('currency')) {
            $currency = $request->input('currency');
            setEnv('CURRENCY', $currency);
        }
        return redirect()->back()->with('success', 'Business Settings updated successfully!');
    }
}
