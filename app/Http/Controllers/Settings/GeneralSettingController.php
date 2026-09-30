<?php

namespace App\Http\Controllers\Settings;

use App\Enums\Seting;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdditionalSettingsUpdateRequest;
use App\Http\Requests\UpdateDownloadLinkRequest;
use App\Http\Requests\UpdateFabIconRequest;
use App\Http\Requests\UpdateFooterLogoRequest;
use App\Http\Requests\UpdateLogoRequest;
use App\Http\Requests\UpdateSocialLinksRequest;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class GeneralSettingController extends Controller
{
    // General Settings Page
    public function index()
    {
        $timezones = []; // initialize
        $timestamp = time();

        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $timezones[$key]['zone'] = $zone;
            $timezones[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }

        $generalSettings = SettingRepository::getAll();

        $generalSettings = $generalSettings->map(function ($item) {
            $item->data = json_decode($item->data, true);
            return $item;
        });

        return view('admin.settings.general.index', compact('generalSettings', 'timezones'));
    }




    // Update Logo
    public function updateLogo(UpdateLogoRequest $request)
    {
        SettingRepository::updateImageSetting(Seting::AppLogo->value, $request, 'logo', 'logos', 'logo_url');
        Cache::forget('shared_data');
        return redirect()->route('general-settings.index')->with('success', 'Logo updated successfully!');
    }

    // Update Favicon-
    public function updateFabicon(UpdateFabIconRequest $request)
    {
        SettingRepository::updateImageSetting(Seting::FabIcon->value, $request, 'fabicon', 'fabicons', 'fav_url');
        Cache::forget('shared_data');
        return redirect()->route('general-settings.index')->with('success', 'Fabicon updated successfully!');
    }

    // Update Footer Logo
    public function updateFooterLogo(UpdateFooterLogoRequest $request)
    {
        SettingRepository::updateImageSetting(Seting::FooterLogo->value, $request, 'footerlogo', 'footer_logos', 'footer_url');
        Cache::forget('all_settings_keyed');
        return redirect()->route('cms-footer.index')->with('success', 'Footer Logo updated successfully!');
    }

    // Update

    public function updateDownloadableLink(UpdateDownloadLinkRequest $request)
    {
        $requestModified = $request->except('_token', '_method');
        $type = Seting::DownloadLinks->value;

        if ($request->hasFile('thumbnail1')) {
            $path = Storage::disk('public')->put('/' . trim('downloadable', '/'), $request->thumbnail1);
            unset($requestModified['thumbnail1']);
            $requestModified['thumbnail1'] = Storage::url($path);
        }

        if ($request->hasFile('thumbnail2')) {
            $path = Storage::disk('public')->put('/' . trim('downloadable', '/'), $request->thumbnail2);
            unset($requestModified['thumbnail2']);
            $requestModified['thumbnail2'] = Storage::url($path);
        }

        SettingRepository::updateDownloadLinks($type, $requestModified);
        Cache::forget('all_settings_keyed');
        return back()->with('success', 'Downloadable Link Section updated successfully.');
    }


    // Update additional settings
    public function updateAdditional(AdditionalSettingsUpdateRequest $request)
    {
        SettingRepository::updateAdditionalSetting(Seting::AppName->value, $request->app_name);
        //  Update Timezone (NEW)
        $timezone = $request->timezone ?? config('app.timezone');
        SettingRepository::updateAdditionalSetting('Timezone', $timezone);

        $this->setEnv('APP_TIMEZONE', $timezone);

        Cache::forget('all_settings_keyed');
        return redirect()->back()->with('success', 'Additional Settings updated successfully!');
    }


    // Update Mail Settings
    public function updateMail(Request $request)
    {
        try {
            $this->setEnv('MAIL_MAILER', $request->mailer);
            $this->setEnv('MAIL_HOST', $request->host);
            $this->setEnv('MAIL_PORT', $request->port);
            $this->setEnv('MAIL_USERNAME', $request->username);
            $this->setEnv('MAIL_PASSWORD', $request->password);
            $this->setEnv('MAIL_ENCRYPTION', $request->encryption);
            $this->setEnv('MAIL_FROM_ADDRESS', $request->from_address);

            $mailConfigData = [
                'mailer'        => $request->mailer,
                'host'          => $request->host,
                'port'          => $request->port,
                'username'      => $request->username,
                'password'      => $request->password,
                'encryption'    => $request->encryption,
                'from_address'  => $request->from_address,
            ];

            SettingRepository::updateMailSetting(Seting::MailConfig->value, $mailConfigData);
            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            Cache::forget('all_settings_keyed');
            return back()->with('success', 'Mail configuration updated successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Update SMS Settings
    public function updateSMS(Request $request)
    {
        $success =
            $this->setSmsEnv('SMS_BASE_URL', $request->url ?? '') &&
            $this->setSmsEnv('SMS_USER_NAME', $request->user_name) &&
            $this->setSmsEnv('SMS_PASSWORD', $request->password) &&
            $this->setSmsEnv('SMS_ORIGINATOR', $request->originator) &&
            $this->setSmsEnv('SMS_ROUTE', $request->route ?? '');


        $smsConfigData = [
            'url'        => $request->input('url'),
            'user_name'  => $request->input('user_name'),
            'password'   => $request->input('password'),
            'originator' => $request->input('originator'),
            'route'      => $request->input('route'),
        ];

        SettingRepository::updateSmsSetting(Seting::SMSConfig->value, $smsConfigData);

        if ($success) {
            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            Cache::forget('all_settings_keyed');
            return back()->with('success', 'SMS configuration updated successfully.');
        }

        return back()->with('error', 'Failed to update SMS configuration. Check file permissions.');
    }
}
