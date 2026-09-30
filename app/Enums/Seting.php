<?php

namespace App\Enums;

enum Seting: string
{
    // General Settings
    case AppLogo = 'App Logo';
    case AppName = 'App Name';
    case SocialLinks = 'Social Links';
    case DownloadLinks = 'Download Links';
    case ThemeColor = 'Theme Color';
    case SecondaryColor = 'Secondary Color';
    case FontFamily = 'Font Family';
    case MailConfig = 'Mail Config';
    case SMSConfig = 'SMS Config';
    case FabIcon = 'Fab Icon';
    case FooterLogo = 'Footer Logo';

        // Business Settings
    case Currency = 'Currency';
    case GST = 'GST';
    case TAX = 'Tax';
    case Address = 'Address';
    case SupportMail = 'Support Mail';
    case SupportCantact = 'Support Contact';
    case FooterCopyright = 'Footer Copyright';
    case FooterSubtitle = 'Footer Subtitle';
    case FooterMenuOrder = 'Footer Menu Order';

        // Policy
    case Policy = 'Policy';

    // Localization label
    public function label(): string
    {
        return __("setting.{$this->value}");
    }
}
