<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Enums\Pages;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pageData = [
            Pages::About->value => [
                [
                    'title' => 'Empowering People to Buy & Sell Smarter',
                    'description' => 'We are more than just a marketplace — we were a movement to make local buying and selling easier, faster, and more human. Our platform connects everyday people to trade used products safely, without fees or middlemen',
                ],
            ],

            Pages::ContactUs->value => [
                [
                    'title' => 'Get in Touch',
                    'description' => 'We’re here to help with any questions, feedback, or support you need',
                ],
            ],

            Pages::PrivacyPolicy->value => [
                [
                    'title' => 'Your data stays yours',
                    'description' => 'We value your privacy and are committed to protecting your personal information. This Privacy Policy outlines how we collect, use, and safeguard your data when you access or use our website and services.',
                ],
            ],

            Pages::TermsConditions->value => [
                [
                    'title' => 'Rules that keep everything fair & safe',
                    'description' => 'Businesses operating online are connected to a world wide web of potential customers, but you’re also exposed to several risks — sometimes at the hands of those same consumers.',
                ],
            ],
        ];

        foreach (Pages::cases() as $page) {
            Page::updateOrCreate(
                ['section' => $page->value],
                [
                    'name' => $page->label(),
                    'data' => $pageData[$page->value] ?? [],
                ]
            );
        }
    }
}
