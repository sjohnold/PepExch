<?php

namespace App\Http\Controllers\API\Master;

use App\Enums\Seting;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\languageResource;
use App\Http\Resources\MasterResource;
use App\Repositories\LanguageRepository;
use App\Repositories\SettingRepository;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;


#[Group('Master')]
class MasterController extends Controller
{

    /**
     * Master API
     *
     */
    public function index()
    {
        $allSettings = SettingRepository::getAll()->keyBy('type');
        $appname = !empty($allSettings[Seting::AppName->value]) ? json_decode($allSettings[Seting::AppName->value]->data) : null;
        $applogo = !empty($allSettings[Seting::AppLogo->value]) ? json_decode($allSettings[Seting::AppLogo->value]->data) : null;
        $fav = !empty($allSettings[Seting::FabIcon->value]) ? json_decode($allSettings[Seting::FabIcon->value]->data) : null;
        $footerLogo = !empty($allSettings[Seting::FooterLogo->value]) ? json_decode($allSettings[Seting::FooterLogo->value]->data) : null;
        $footerAddress = !empty($allSettings[Seting::Address->value]) ? json_decode($allSettings[Seting::Address->value]->data) : null;
        $footerSupportMail = !empty($allSettings[Seting::SupportMail->value]) ? json_decode($allSettings[Seting::SupportMail->value]->data) : null;
        $footerContact = !empty($allSettings[Seting::SupportCantact->value]) ? json_decode($allSettings[Seting::SupportCantact->value]->data) : null;
        $footerTitle = !empty($allSettings[Seting::FooterSubtitle->value]) ? json_decode($allSettings[Seting::FooterSubtitle->value]->data) : null;
        $currency = !empty($allSettings[Seting::Currency->value]) ? json_decode($allSettings[Seting::Currency->value]->data) : null;
        $gst = !empty($allSettings[Seting::GST->value]) ? json_decode($allSettings[Seting::GST->value]->data) : null;
        $tax = !empty($allSettings[Seting::TAX->value]) ? json_decode($allSettings[Seting::TAX->value]->data) : null;

        $downloadableLinks = !empty($allSettings[Seting::DownloadLinks->value]) ? json_decode($allSettings[Seting::DownloadLinks->value]->data) : null;

        $themeColors = [];
        $themeColors = !empty($allSettings[Seting::ThemeColor->value]) ? json_decode($allSettings[Seting::ThemeColor->value]->data, true) ?? [] : [];

        $socialLinksData = !empty($allSettings['Social Links']) ? json_decode($allSettings['Social Links']->data) : [];
        $socialLinks = [];
        foreach ($socialLinksData as $key => $link) {
            $socialLinks[] = [
                'name' => $key,
                'url' => $link->url,
                'icon' => $link->icon
            ];
        }

        $languages = LanguageRepository::getAll();



        $data = [
            'app_name' => $appname?->value,
            'logo' => $applogo?->logo_url,
            'favicon' => $fav?->fav_url,
            'footer_logo' => $footerLogo?->footer_url,
            'address' => $footerAddress->value,
            'support_mail' => $footerSupportMail->value,
            'support_contact' => $footerContact->value,
            'footer_title' => $footerTitle->value,
            'gst' => (int) $gst->value,
            'tax' => (int) $tax->value,
            'downloadableLinks' => $downloadableLinks,
            'theme_colors' => $themeColors,
            'currency' => $currency->currency,
            'currency_symbol' => $currency->symbol,
            'currency_position' => $currency->position,
            'socialLinks' => $socialLinks,
            'languages' => languageResource::collection($languages),
        ];

        return $this->json('Master Fetch Successfully', $data);
    }
}
