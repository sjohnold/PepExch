<?php

namespace App\Http\Controllers\CMS;

use App\Enums\Seting;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class CMSController extends Controller
{
    public function index()
    {
        $footerSettings = SettingRepository::query()
            ->whereIn('type', [
                'Footer Logo',
                'Footer Subtitle',
                'Footer Copyright',
                'Address',
                'Support Mail',
                'Support Contact',
                'Social Links',
                'Footer Menu Order'
            ])
            ->get()
            ->keyBy('type');

        // Footer Logo
        $footerLogoUrl = null;
        if (isset($footerSettings['Footer Logo'])) {
            $data = json_decode($footerSettings['Footer Logo']->data, true);
            $footerLogoUrl = $data['footer_url'] ?? null;
        }

        // Footer Subtitle
        $footerSubtitle = null;
        if (isset($footerSettings['Footer Subtitle'])) {
            $data = json_decode($footerSettings['Footer Subtitle']->data, true);
            $footerSubtitle = $data['value'] ?? null;
        }

        // Footer Copyright
        $footerCopyright = null;
        if (isset($footerSettings['Footer Copyright'])) {
            $data = json_decode($footerSettings['Footer Copyright']->data, true);
            $footerCopyright = $data['value'] ?? null;
        }

        // Footer Info
        $address = $supportMail = $supportContact = null;

        if (isset($footerSettings['Address'])) {
            $data = json_decode($footerSettings['Address']->data, true);
            $address = $data['value'] ?? null;
        }

        if (isset($footerSettings['Support Mail'])) {
            $data = json_decode($footerSettings['Support Mail']->data, true);
            $supportMail = $data['value'] ?? null;
        }

        if (isset($footerSettings['Support Contact'])) {
            $data = json_decode($footerSettings['Support Contact']->data, true);
            $supportContact = $data['value'] ?? null;
        }

        // Social Links
        $socialLinksData = [];
        if (isset($footerSettings['Social Links'])) {
            $socialLinksData = json_decode($footerSettings['Social Links']->data, true);
        }

        // Footer Menu Cards with Items
        $footerMenuCards = [];
        if (isset($footerSettings['Footer Menu Order'])) {
            $data = json_decode($footerSettings['Footer Menu Order']->data, true);
            $footerMenuCards = $data['cards'] ?? [];

            // Sort cards by order
            usort($footerMenuCards, function ($a, $b) {
                return ($a['order'] ?? 0) - ($b['order'] ?? 0);
            });

            // Sort items within each card
            foreach ($footerMenuCards as &$card) {
                if (isset($card['items'])) {
                    usort($card['items'], function ($a, $b) {
                        return ($a['order'] ?? 0) - ($b['order'] ?? 0);
                    });
                }
            }
        }

        return view(
            'admin.cms.footer.index',
            compact(
                'footerLogoUrl',
                'footerSubtitle',
                'footerCopyright',
                'address',
                'supportMail',
                'supportContact',
                'socialLinksData',
                'footerMenuCards'
            )
        );
    }

    public function updateSubtitle(Request $request)
    {
        $result = SettingRepository::updateSubtitleByRepo($request);
        SettingsService::clearCache();
        if (!$result) {
            return redirect()->back()->with('error', 'Footer settings could not be updated.');
        }
        return redirect()->back()->with('success', 'Footer settings updated successfully.');
    }

    public function updateSocial(Request $request)
    {
        SettingRepository::updateSocialLinks(Seting::SocialLinks->value, $request);
        SettingsService::clearCache();
        return redirect()->back()->with('success', 'Social Links updated successfully!');
    }

    public function updateFooterInfo(Request $request)
    {
        $fullContact = '';
        if ($request->has('country_code') && $request->has('support_contact')) {
            $fullContact = $request->country_code . $request->support_contact;
        }

        $modifiedRequest = clone $request;
        $modifiedRequest->merge(['support_contact' => $fullContact]);

        $result = SettingRepository::updateFooterInfomation($modifiedRequest);
        SettingsService::clearCache();

        if (!$result) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Footer info could not be updated.'], 400);
            }
            return redirect()->back()->with('error', 'Footer info could not be updated.');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Footer info updated successfully!']);
        }
        return redirect()->back()->with('success', 'Footer info updated successfully.');
    }

    public function updateFooterMenuOrder(Request $request)
    {
        $cards = $request->cards;

        SettingRepository::updateFooterMenuOrder($cards);
        SettingsService::clearCache();

        return response()->json(['success' => true, 'message' => 'Footer menu updated successfully!']);
    }


    public function resetFooterMenu()
    {
        $defaultData = [
            'cards' => [
                [
                    'id' => 'footer-info',
                    'label' => 'Footer Information',
                    'is_active' => true,
                    'order' => 1,
                    'items' => [
                        ['id' => 'address', 'label' => 'Address', 'is_active' => true, 'order' => 1, 'url' => ''],
                        ['id' => 'support_mail', 'label' => 'Support Mail', 'is_active' => true, 'order' => 2, 'url' => ''],
                        ['id' => 'support_contact', 'label' => 'Support Contact', 'is_active' => true, 'order' => 3, 'url' => ''],
                    ]
                ],
                [
                    'id' => 'quick-links',
                    'label' => 'Quick Links',
                    'is_active' => true,
                    'order' => 2,
                    'items' => [
                        ['id' => 'subscription', 'label' => 'Subscription', 'is_active' => true, 'order' => 1, 'url' => '#'],
                        ['id' => 'add_post', 'label' => 'Add Post', 'is_active' => true, 'order' => 2, 'url' => ''],
                        ['id' => 'login', 'label' => 'Login', 'is_active' => true, 'order' => 3, 'url' => ''],
                        ['id' => 'registration', 'label' => 'Registration', 'is_active' => true, 'order' => 4, 'url' => ''],
                    ]
                ],
                [
                    'id' => 'company',
                    'label' => 'Company',
                    'is_active' => true,
                    'order' => 3,
                    'items' => [
                        ['id' => 'about_us', 'label' => 'About Us', 'is_active' => true, 'order' => 1, 'url' => ''],
                        ['id' => 'most_popular', 'label' => 'Most Popular', 'is_active' => true, 'order' => 2, 'url' => ''],
                        ['id' => 'terms', 'label' => 'Terms & Conditions', 'is_active' => true, 'order' => 3, 'url' => ''],
                        ['id' => 'privacy', 'label' => 'Privacy Policy', 'is_active' => true, 'order' => 4, 'url' => ''],
                    ]
                ],
                [
                    'id' => 'help-support',
                    'label' => 'Help & Support',
                    'is_active' => true,
                    'order' => 4,
                    'items' => [
                        ['id' => 'faq', 'label' => 'FAQ', 'is_active' => true, 'order' => 1, 'url' => '#'],
                        ['id' => 'stay_safe', 'label' => 'Stay Safe', 'is_active' => true, 'order' => 2, 'url' => '#'],
                        ['id' => 'contact', 'label' => 'Contact Us', 'is_active' => true, 'order' => 3, 'url' => ''],
                    ]
                ],
            ]
        ];

        SettingRepository::query()->updateOrCreate(
            ['type' => Seting::FooterMenuOrder->value],
            ['data' => json_encode($defaultData)]
        );
        SettingsService::clearCache();

        return response()->json([
            'success' => true,
            'message' => 'Footer menu reset to default successfully!'
        ]);
    }
}
