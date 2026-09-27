<?php

namespace Botble\Member\Http\Requests;

use Botble\Member\Enums\PaymentMethodType;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PaymentMethodRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'type' => ['required', Rule::in(PaymentMethodType::values())],
            'is_default' => ['nullable', 'boolean'],
        ];

        foreach ($this->selectedType()?->fields() ?? [] as $name => $field) {
            $rules[$name] = $field['rules'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return ['type' => 'método de pago'] + array_map(
            fn (array $field) => mb_strtolower($field['label']),
            $this->selectedType()?->fields() ?? []
        );
    }

    public function messages(): array
    {
        return [
            'wallet.regex' => 'La dirección de la wallet no es válida para la red elegida.',
        ];
    }

    public function paymentType(): PaymentMethodType
    {
        return PaymentMethodType::from($this->input('type'));
    }

    /**
     * @return array<string, string>
     */
    public function details(): array
    {
        return collect($this->paymentType()->fields())
            ->keys()
            ->mapWithKeys(fn (string $name) => [$name => trim((string) $this->input($name))])
            ->filter(fn (string $value) => $value !== '')
            ->all();
    }

    protected function selectedType(): ?PaymentMethodType
    {
        return PaymentMethodType::tryFrom((string) $this->input('type'));
    }
}
