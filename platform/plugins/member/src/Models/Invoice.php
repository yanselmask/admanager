<?php

namespace Botble\Member\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Models\BaseModel;
use Botble\Member\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends BaseModel
{
    protected $table = 'invoices';

    protected $fillable = [
        'name',
        'invoice_date',
        'currency',
        'amount',
        'member_id',
        'payment_method_id',
        'status',
    ];

    protected $casts = [
        //        'status' => InvoiceStatus::class,
        'name' => SafeContent::class,
        'invoice_date' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $invoiceNumber = generate_invoice();
            $model->name = $invoiceNumber;
        });

        static::saving(function (Invoice $invoice): void {
            if (! $invoice->isDirty('payment_method_id')) {
                return;
            }

            $method = $invoice->payment_method_id ? MemberPaymentMethod::query()->find($invoice->payment_method_id) : null;

            $invoice->payment_method_label = $method ? $method->type->label().' · '.$method->summary : null;
        });
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(MemberPaymentMethod::class, 'payment_method_id');
    }
}
