<?php

namespace App\Enums;

enum UserStatus: string
{
    case Pending = 'Pending';
    case Approve = 'Approve';
    case BlockSelling = 'Block Selling';
    case Block = 'Block';
    case Hold = 'Hold';

    // localized value getter
    public function label(): string
    {
        return match ($this) {
            self::Pending => __('Pending'),
            self::Approve => __('Approve'),
            self::BlockSelling => __('Block Selling'),
            self::Block => __('Block'),
            self::Hold => __('Hold'),
        };
    }
}
