<?php

namespace Database\Seeders;

use App\Enums\Seting;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{

    public function run(): void
    {
        $settingsData = [
            Seting::AppLogo->value => ['logo_url' => asset('assets/frontend/img/logo/header-logo.png')],
            Seting::FooterLogo->value => ['footer_url' => asset('assets/frontend/img/logo/footer-logo.png')],
            Seting::FabIcon->value => ['fav_url' => asset('assets/frontend/img/logo/favicon.png')],
            Seting::Currency->value => ['symbol' => '$', 'currency' => 'USD', 'position' => 'left'],
            Seting::GST->value => ['type' => 'percentage', 'value' => 15],
            Seting::TAX->value => ['type' => 'percentage', 'value' => 0],
            Seting::Address->value => ['value' => 'Belgrade, Serbia'],
            Seting::SupportMail->value => ['value' => 'support@pepexch.example'],
            Seting::SupportCantact->value => ['value' => '+381 11 000 000'],
            Seting::FooterCopyright->value => ['value' => '(c) 2026 PepExch. All rights reserved.'],
            Seting::FooterSubtitle->value => ['value' => 'PepExch is a simple and secure platform for exchanging items without cash.'],
            Seting::AppName->value => ['value' => 'PepExch'],
            Seting::DownloadLinks->value => [
                'thumbnail1' => asset('media/market/p-6.jpg'),
                'thumbnail2' => asset('media/market/p-9.jpg'),
                'title' => 'Download Our App',
                'subtitle' => 'Available on iOS & Android',
                'description' => 'Get the best shopping experience on your mobile device',
                'app_store_url' => '',
                'play_store_url' => ''
            ],
            Seting::MailConfig->value => [
                'mailer' => 'smtp',
                'host' => 'smtp.mailtrap.io',
                'port' => '2525',
                'username' => 'your_username',
                'password' => 'your_password',
                'encryption' => 'tls',
                'from_address' => 'noreply@pepexch.example',
                'from_name' => 'PepExch'
            ],
            Seting::SMSConfig->value => [
                'url' => 'https://api.smsgateway.com/send',
                'user_name' => 'your_username',
                'password' => 'your_password',
                'originator' => 'PEPEXCH',
                'route' => 'default'
            ],
            Seting::Policy->value => [
                'content' => 'Our marketplace is committed to providing a secure and transparent platform for buyers and sellers.'
            ],

            // NEW STRUCTURE - Footer Menu with Items (NOW WITH URL FIELD)
            Seting::FooterMenuOrder->value => [
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
            ],
        ];

        foreach ($settingsData as $type => $data) {
            Setting::updateOrCreate(['type' => $type], ['data' => json_encode($data)]);
        }

        // Social Links
        $socialLinks = [
            ['icon' => 'facebook', 'label' => 'Facebook', 'url' => 'https://facebook.com/yourpage'],
        ];

        Setting::updateOrCreate(
            ['type' => 'Social Links'],
            ['data' => json_encode($socialLinks)]
        );

        // Theme Color
        Setting::updateOrCreate(
            ['type' => Seting::ThemeColor->value],
            ['data' => json_encode(['primary_color' => '#dd5454', 'text_color' => '#17181d'])]
        );
    }
}
