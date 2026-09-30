<?php

namespace App\Enums;

enum Cms: string
{
    case Banner = 'Banner';
    case FastSelling = 'Fast Selling';
    case Review = 'Review';
    case AppDownload = 'App Download';


     public function label(): string
    {
        return match($this) {
            self::Banner => __('Banner'),
            self::FastSelling => __('Fast Selling'),
            self::Review => __('Review'),
            self::AppDownload => __('App Download'),
        };
    }
}
