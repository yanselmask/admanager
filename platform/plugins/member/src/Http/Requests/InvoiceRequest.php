<?php

namespace Botble\Member\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Member\Enums\InvoiceStatus;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class InvoiceRequest extends Request
{
    public function rules(): array
    {
        return [
            'invoice_date' => ['nullable', 'string', 'max:255'],
            'amount' => ['nullable', 'string', 'max:255'],
            'status' => Rule::in(InvoiceStatus::values()),
        ];
    }
}
