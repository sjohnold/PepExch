<?php

namespace App\Enums;

enum Conditions: string
{
    case UsedLikeNew = 'Used Like New';
    case BrandNew = 'Brand New';



    public function label(): string
    {
        return match ($this) {
            self::UsedLikeNew => __('Used Like New'),
            self::BrandNew => __('Brand New'),
        };
    }
}
