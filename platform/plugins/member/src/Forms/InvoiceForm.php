<?php

namespace Botble\Member\Forms;

use Botble\Base\Forms\FieldOptions\DatePickerFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\DatePickerField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\FormAbstract;
use Botble\Member\Enums\InvoiceStatus;
use Botble\Member\Http\Requests\InvoiceRequest;
use Botble\Member\Models\Invoice;
use Botble\Member\Models\Member;
use Botble\Member\Models\MemberPaymentMethod;

class InvoiceForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Invoice::class)
            ->setValidatorClass(InvoiceRequest::class)
            ->add('invoice_date',
                DatePickerField::class,
                DatePickerFieldOption::make()->required()
            )
            ->add('currency',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Currency'))
                    ->choices(currencies_codes())
            )
            ->add('amount',
                NumberField::class,
                NumberFieldOption::make()
                    ->placeholder(__('Amount'))
                    ->required()
            )
            ->add('member_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Author'))
                    ->choices(is_plugin_active('member') ? Member::query()->pluck('first_name', 'id')->toArray() : [])
                    ->searchable()
            )
            ->add('payment_method_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label('Método de pago usado')
                    ->choices(['' => 'Sin especificar'] + $this->paymentMethodChoices())
                    ->searchable()
                    ->helperText('Debe ser uno de los métodos del miembro de esta factura.')
            )
            ->add('status',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Status'))
                    ->choices(InvoiceStatus::choices())
            )
            ->setBreakFieldPoint('status');
    }

    /**
     * Al editar se ofrecen solo los métodos del miembro de la factura; al crear, los de todos,
     * con el nombre del miembro delante para distinguirlos.
     *
     * @return array<int, string>
     */
    protected function paymentMethodChoices(): array
    {
        $memberId = $this->getModel()->member_id ?? null;

        return MemberPaymentMethod::query()
            ->with('member:id,first_name,last_name')
            ->when($memberId, fn ($query) => $query->where('member_id', $memberId))
            ->orderByDesc('is_default')
            ->latest()
            ->get()
            ->mapWithKeys(fn (MemberPaymentMethod $method) => [
                $method->getKey() => ($memberId ? '' : $method->member?->name.' — ')
                    .$method->type->label().' · '.$method->summary
                    .($method->is_default ? ' (predeterminado)' : ''),
            ])
            ->all();
    }
}
