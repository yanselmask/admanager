<?php

namespace Botble\Member\Http\Requests;

use Botble\Member\Enums\InvoiceStatus;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class InvoiceRequest extends Request
{
    protected function prepareForValidation(): void
    {
        if ($this->input('payment_method_id') === '') {
            $this->merge(['payment_method_id' => null]);
        }
    }

    public function rules(): array
    {
        return [
            'invoice_date' => ['nullable', 'string', 'max:255'],
            'amount' => ['nullable', 'string', 'max:255'],
            'status' => Rule::in(InvoiceStatus::values()),
            'payment_method_id' => [
                'nullable',
                'integer',
                Rule::exists('member_payment_methods', 'id')->where('member_id', $this->input('member_id')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method_id.exists' => 'El método de pago elegido no pertenece al miembro de la factura.',
        ];
    }
}
