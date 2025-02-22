<?php

namespace Botble\Member\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Member\Enums\InvoiceStatus;

class Invoice extends BaseModel
{
    protected $table = 'invoices';

    protected $fillable = [
        'name',
        'invoice_date',
        'currency',
        'amount',
        'member_id',
        'status',
    ];

    protected $casts = [
//        'status' => InvoiceStatus::class,
        'name' => SafeContent::class,
        'invoice_date' => 'datetime'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $invoiceNumber = generate_invoice();
            $model->name = $invoiceNumber;
        });
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
