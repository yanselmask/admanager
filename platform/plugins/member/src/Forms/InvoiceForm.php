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
            ->add('status',
                SelectField::class,
                SelectFieldOption::make()
                ->label(__('Status'))
                ->choices(InvoiceStatus::choices())
            )
            ->setBreakFieldPoint('status');
    }
}
