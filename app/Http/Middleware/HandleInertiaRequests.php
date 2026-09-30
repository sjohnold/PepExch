<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Enums\Seting;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $sharedData = app('shared_data');
        $settings = $sharedData['settings'];
        $settingValue = fn (string $key) => ($setting = $settings->get($key))
            ? json_decode($setting->data)
            : null;
        
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'settings' => $settings,
            'themeColors' => $sharedData['themeColors'],
            'footerMenuCards' => $sharedData['footerMenuCards'],
            'navigation' => $sharedData['navigation'] ?? ['main' => [], 'sidebar' => [], 'footer' => []],
            'applogo' => $settingValue(Seting::AppLogo->value),
            'footerLogo' => $settingValue(Seting::FooterLogo->value),
            'footerCopyright' => $settingValue(Seting::FooterCopyright->value),
            'footerSubtitle' => $settingValue(Seting::FooterSubtitle->value),
            'socialLinks' => $settingValue(Seting::SocialLinks->value),
            'downloadLinks' => $settingValue(Seting::DownloadLinks->value),
        ];
    }
}
