<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $businessSettings = SettingRepository::getAllBusinessSettings();
        $addressSetting        = $businessSettings->where('type', 'Address')->first();
        $supportMailSetting    = $businessSettings->where('type', 'Support Mail')->first();
        $supportContactSetting = $businessSettings->where('type', 'Support Contact')->first();

        return \Inertia\Inertia::render('About', [
            'support' => [
                'address' => $this->settingValue($addressSetting),
                'email' => $this->settingValue($supportMailSetting),
                'phone' => $this->settingValue($supportContactSetting),
            ],
        ]);
    }

    private function settingValue($setting): ?string
    {
        $data = $setting?->data ?? null;

        if (is_string($data)) {
            $data = json_decode($data);
        }

        if (is_array($data)) {
            return $data['value'] ?? null;
        }

        return $data?->value ?? null;
    }
}
