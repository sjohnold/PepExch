<?php

namespace App\Providers;

use App\Enums\Seting;
use App\Repositories\CategoryRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Repositories\LanguageRepository;
use App\Repositories\UserRepository;
use Illuminate\Pagination\Paginator;
use App\Models\Category;
use App\Models\Banner;
use App\Models\BoostPlan;
use App\Models\BoostPost;
use App\Models\SellingPost;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Setting;
use App\Models\FastSelling;
use App\Models\Language;
use App\Models\NavigationItem;
use App\Models\Wishlist;
use App\Observers\HomeCacheObserver;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        app()->singleton('shared_data', function () {
            return app(SettingsService::class)->sharedData();
        });
    }


    public function boot()
    {
        Category::observe(HomeCacheObserver::class);
        Banner::observe(HomeCacheObserver::class);
        BoostPost::observe(HomeCacheObserver::class);
        BoostPlan::observe(HomeCacheObserver::class);
        SellingPost::observe(HomeCacheObserver::class);
        Service::observe(HomeCacheObserver::class);
        Testimonial::observe(HomeCacheObserver::class);
        Setting::observe(HomeCacheObserver::class);
        NavigationItem::observe(HomeCacheObserver::class);
        FastSelling::observe(HomeCacheObserver::class);
        Language::observe(HomeCacheObserver::class);



        View::composer([
            'web.*',
            'partials.*',
            'layouts.*',
            'admin.layouts.*',
            'admin.reports.*',
            'components.*',
            'auth.*',
        ], function ($view) {

            $data = app('shared_data');

            $languages = $data['languages'];
            $categories = $data['categories'];
            $settings = $data['settings'];

            $currentLanguage = app()->getLocale();

            // Decode settings safely
            $socialLinks = !empty($settings['Social Links'])
                ? json_decode($settings['Social Links']->data)
                : null;

            $allData = !empty($settings[Seting::DownloadLinks->value])
                ? json_decode($settings[Seting::DownloadLinks->value]->data)
                : null;

            $footerAddress = !empty($settings[Seting::Address->value])
                ? json_decode($settings[Seting::Address->value]->data)
                : null;

            $footerSupportMail = !empty($settings[Seting::SupportMail->value])
                ? json_decode($settings[Seting::SupportMail->value]->data)
                : null;

            $footerContact = !empty($settings[Seting::SupportCantact->value])
                ? json_decode($settings[Seting::SupportCantact->value]->data)
                : null;

            $footerCopyright = !empty($settings[Seting::FooterCopyright->value])
                ? json_decode($settings[Seting::FooterCopyright->value]->data)
                : null;

            $footerLogo = !empty($settings[Seting::FooterLogo->value])
                ? json_decode($settings[Seting::FooterLogo->value]->data)
                : null;

            $applogo = !empty($settings[Seting::AppLogo->value])
                ? json_decode($settings[Seting::AppLogo->value]->data)
                : null;

            $footerSubtitle = !empty($settings[Seting::FooterSubtitle->value])
                ? json_decode($settings[Seting::FooterSubtitle->value]->data)
                : null;

            $appname = !empty($settings[Seting::AppName->value])
                ? json_decode($settings[Seting::AppName->value]->data)
                : null;

            $fav = !empty($settings[Seting::FabIcon->value])
                ? json_decode($settings[Seting::FabIcon->value]->data)
                : null;

            $themeColors = $data['themeColors'];
            $footerMenuCards = $data['footerMenuCards'];
            $navigationMain = $data['navigation']['main'] ?? [];
            $navigationSidebar = $data['navigation']['sidebar'] ?? [];

            // Storage link check
            $storageLink = !file_exists(public_path('storage'));


            $wishListcount = Auth::check() ? Wishlist::where('user_id', Auth::id())->count() : 0;

            $view->with([
                'languages' => $languages,
                'currentLanguage' => $currentLanguage,
                'categories' => $categories,
                'socialLinks' => $socialLinks,
                'footerAddress' => $footerAddress,
                'footerSupportMail' => $footerSupportMail,
                'footerContact' => $footerContact,
                'footerCopyright' => $footerCopyright,
                'footerLogo' => $footerLogo,
                'footerSubtitle' => $footerSubtitle,
                'applogo' => $applogo,
                'appname' => $appname,
                'themeColors' => $themeColors,
                'fav' => $fav,
                'storageLink' => $storageLink,
                'wishListcount' => $wishListcount,
                'footerMenuCards' => $footerMenuCards,
                'navigationMain' => $navigationMain,
                'navigationSidebar' => $navigationSidebar,
                'allData'=>$allData,
            ]);
        });

        Paginator::useBootstrapFive();
    }
}
