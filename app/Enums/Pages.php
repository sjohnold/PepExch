<?php

namespace App\Enums;

enum Pages: string
{
    case About = 'about';
    case ContactUs = 'contact-us';
    case PrivacyPolicy = 'privacy-policy';
    case TermsConditions = 'terms-conditions';

    public function label(): string
    {
        return match ($this) {
            self::About => 'About Us',
            self::ContactUs => 'Contact Us',
            self::PrivacyPolicy => 'Privacy Policy',
            self::TermsConditions => 'Terms & Conditions',
        };
    }
}
