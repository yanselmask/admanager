<?php

namespace Botble\Member\Enums;

enum KycStatus: string
{
    case PENDING = 'pending';
    case VERIFIED = 'verified';
    case REJECTED = 'rejected';

    public static function choices(): array
    {
        return [
            'pending' => __('Pending'),
            'verified' => __('Verified'),
            'rejected' => __('Rejected')
        ];
    }
    public static function badge($value) {
        return match ($value){
            self::PENDING => '<div class="badge bg-warning text-warning-fg">' . __('Pending') . '</div>',
            self::VERIFIED => '<div class="badge bg-success text-success-fg">' . __('Verified') . '</div>',
            self::REJECTED => '<div class="badge bg-danger text-danger-fg">' . __('Rejected') . '</div>'
        };
    }
}

