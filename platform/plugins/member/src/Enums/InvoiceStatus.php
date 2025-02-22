<?php

namespace Botble\Member\Enums;

enum InvoiceStatus: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case UNPAID = 'unpaid';

    case PARTIALLY_PAID = 'partially_paid';


    public static function choices(): array
    {
        return [
            'pending' => __('Pending'),
            'paid' => __('Paid'),
            'unpaid' => __('Unpaid'),
            'partially_paid' => __('Partially paid'),
        ];
    }

    public static function values(): array
    {
        return ['pending', 'paid', 'unpaid', 'partially_paid'];
    }

    public static function badge($value) {
        return match ($value){
          'pending' => '<div class="badge bg-warning text-warning-fg">' . __('Pending') . '</div>',
          'paid' => '<div class="badge bg-success text-success-fg">' . __('Paid') . '</div>',
          'unpaid' => '<div class="badge bg-danger text-danger-fg">' . __('Unpaid') . '</div>',
          'partially_paid' => '<div class="badge bg-secondary text-secondary-fg">' . __('Partially paid') . '</div>',
        };
    }
}

