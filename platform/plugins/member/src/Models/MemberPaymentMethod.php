<?php

namespace Botble\Member\Models;

use Botble\Base\Models\BaseModel;
use Botble\Member\Enums\PaymentMethodType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class MemberPaymentMethod extends BaseModel
{
    protected $table = 'member_payment_methods';

    protected $fillable = [
        'member_id',
        'type',
        'details',
        'is_default',
    ];

    protected $casts = [
        'type' => PaymentMethodType::class,
        'details' => 'encrypted:array',
        'is_default' => 'boolean',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    /**
     * Dato principal del método (correo, wallet o cuenta), enmascarado para mostrarlo en listados.
     */
    public function getSummaryAttribute(): string
    {
        $details = $this->details ?? [];

        return match ($this->type) {
            PaymentMethodType::PAYPAL => (string) ($details['email'] ?? ''),
            PaymentMethodType::USDT_TRC20, PaymentMethodType::USDT_BEP20 => Str::mask((string) ($details['wallet'] ?? ''), '•', 6, -6),
            PaymentMethodType::BANK => trim(($details['bank_name'] ?? '').' · '.Str::mask((string) ($details['account_number'] ?? ''), '•', 0, -4), ' ·'),
        };
    }
}
