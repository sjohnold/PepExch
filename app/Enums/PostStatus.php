<?php

namespace App\Enums;

enum PostStatus: string
{
    case Pending = 'Pending';
    case InReview = 'In-Review';
    case Approve = 'Approve';
    case Reject = 'Reject';
    case Soled = 'Soled';
    case Cancel = 'Cancel';


    public function label(): string
    {
        return match($this) {
            self::Pending => __('Pending'),
            self::InReview => __('In-Review'),
            self::Approve => __('Approve'),
            self::Reject => __('Reject'),
            self::Soled => __('Soled'),
            self::Cancel => __('Cancel'),
        };
    }
}
