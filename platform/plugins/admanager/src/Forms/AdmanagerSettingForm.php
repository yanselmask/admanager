<?php

namespace Botble\Admanager\Forms;

use Botble\Admanager\Http\Requests\AdmanagerRequest;
use Botble\Base\Forms\FieldOptions\MediaFileFieldOption;
use Botble\Base\Forms\FieldOptions\MultiChecklistFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\RepeaterFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\MediaFileField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\RepeaterField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Setting\Forms\SettingForm;

class AdmanagerSettingForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();

        $fields = [
            [
                'type' => 'text',
                'label' => trans('Ad Manager Network Name'),
                'attributes' => [
                    'name' => 'name',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'type' => 'text',
                'label' => trans('Ad Manager Network Code'),
                'attributes' => [
                    'name' => 'code',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
        ];

        $choices = [
            'today' => __('Today'),
            'yesterday' => __('Yesterday'),
            'this_week' => __('This Week'),
            'this_month' => __('This Month'),
            'last_month' => __('Last Month'),
            'last_week' => __('Last Week'),
            'last_2_months' => __('Last 2 Months'),
            'last_3_months' => __('Last 3 Months'),
            'last_6_months' => __('Last 6 Months'),
            'last_9_months' => __('Last 9 Months'),
            'this_year' => __('This Year'),
        ];

        $fieldName = [
            [
                'type' => 'text',
                'label' => trans('Name'),
                'attributes' => [
                    'name' => 'name',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ]
        ];
        $currencyFields = [
            [
                'type' => 'text',
                'label' => trans('Name'),
                'attributes' => [
                    'name' => 'name',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'type' => 'text',
                'label' => trans('Code'),
                'attributes' => [
                    'name' => 'code',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'type' => 'text',
                'label' => trans('Symbol'),
                'attributes' => [
                    'name' => 'symbol',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ]
        ];

        $this
            ->setSectionTitle(trans('Google Ad Manager'))
            ->setSectionDescription(trans('Configure your Google Ad manager'))
            ->setValidatorClass(AdmanagerRequest::class)
            ->add(
                    'admanager_networks',
                    RepeaterField::class,
                    RepeaterFieldOption::make()
                        ->label(trans('Admanager Networks'))
                        ->value(setting('admanager_networks', []))
                        ->fields($fields)
                )
            ->add('admanager_json',
                MediaFileField::class,
                MediaFileFieldOption::make()->label(__('Your Json'))
                    ->required()
                    ->value(setting('admanager_json'))
            )
            ->add('percentage_default',
                TextField::class,
                TextFieldOption::make()->label(__('Your Percentage'))
                    ->value(setting('percentage_default'))
                    ->required()
                    ->helperText(__('Esta es la comisión que te llevas por cada dominió'))
            )
            ->add('referral_commissions',
                TextField::class,
                TextFieldOption::make()->label(__('Commissions for referral'))
                    ->value(setting('referral_commissions'))
                    ->required()
                    ->helperText(__('La comisión que obtenga el referido'))
            )
            ->add('week_start',
            SelectField::class,
                SelectFieldOption::make()
                ->label(__('Week Start'))
                ->choices([
                    0 => __('Sunday'),
                    1 => __('Monday'),
                    2 => __('Tuesday'),
                    3 => __('Wednesday'),
                    4 => __('Thursday'),
                    5 => __('Friday'),
                    6 => __('Saturday'),
                ])
                ->defaultValue(setting('week_start'))
                ->helperText(__('Elige cuando quieres que empiece la semana'))
            )
            ->add('earning_member',
                \Botble\Base\Forms\Fields\MultiCheckListField::class,
                 MultiChecklistFieldOption::make()->label(__('Earning'))
                    ->choices($choices)
                    ->multiple()
                    ->selected(setting('earning_member') ? json_decode(setting('earning_member')) : '')
            )
            ->add('impressions_member',
                \Botble\Base\Forms\Fields\MultiCheckListField::class,
                MultiChecklistFieldOption::make()->label(__('Impressions'))
                    ->choices($choices)
                    ->multiple()
                    ->selected(json_decode(setting('impressions_member')))
            )
            ->add('include_percentage_in_impressions',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(__('Incluir porcentaje en Impresiones'))
                    ->value(setting('include_percentage_in_impressions', false))
            )
            ->add('clicks_member',
                \Botble\Base\Forms\Fields\MultiCheckListField::class,
                MultiChecklistFieldOption::make()->label(__('Clicks'))
                    ->choices($choices)
                    ->multiple()
                    ->selected(json_decode(setting('clicks_member')))
            )
            ->add('include_percentage_in_clicks',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(__('Incluir porcentaje en Clicks'))
                    ->value(setting('include_percentage_in_clicks', false))
            )
            ->add('ctrs_member',
                \Botble\Base\Forms\Fields\MultiCheckListField::class,
                MultiChecklistFieldOption::make()->label(__('Ctrs'))
                    ->choices($choices)
                    ->multiple()
                    ->selected(json_decode(setting('ctrs_member')))
            )
            ->add('include_percentage_in_ctrs',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(__('Incluir porcentaje en Ctrs'))
                    ->value(setting('include_percentage_in_ctrs', false))
            )
            ->add('ecpms_member',
                \Botble\Base\Forms\Fields\MultiCheckListField::class,
                MultiChecklistFieldOption::make()->label(__('Ecpms'))
                    ->multiple()
                    ->choices($choices)
                    ->selected(json_decode(setting('ecpms_member')))
            )
            ->add('include_percentage_in_ecpm',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(__('Incluir porcentaje en Ecpm'))
                    ->value(setting('include_percentage_in_ecpm', false))
            )
            ->add('support_number',
                TextField::class,
                TextFieldOption::make()->label(__('Support Number'))
                    ->value(setting('support_number'))
                    ->helperText(__('Escriba un número de soporte'))
            )
            ->add('support_message',
                TextareaField::class,
                TextareaFieldOption::make()->label(__('Support Message'))
                    ->value(setting('support_message'))
                    ->helperText(__('Escriba un mensaje por defecto'))
            )
            ->add('member_kyc_is_required',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(__('KYC is required'))
                    ->value(setting('member_kyc_is_required', false))
            )
            ->add('kyc_fields',
                \Botble\Base\Forms\Fields\MultiCheckListField::class,
                MultiChecklistFieldOption::make()->label(__('Kyc fields'))
                    ->choices([
                        'name' => __('Name'),
                        'last_name' => __('Last Name'),
                        'address' => __('Address'),
                        'nationality' => __('Nationality'),
                        'document_type' => __('Document Type'),
                        'document_number' => __('Document Number'),
                        'document_front' => __('Document Front'),
                        'document_back' => __('Document Back'),
                        'selfie' => __('Selfie'),
                    ])
                    ->multiple()
                    ->selected(json_decode(setting('kyc_fields')))
            )
            ->add(
                'kyc_nationalities',
                RepeaterField::class,
                RepeaterFieldOption::make()
                    ->label(trans('Kyc Nationalities'))
                    ->value(setting('kyc_nationalities', []))
                    ->fields($fieldName)
            )
            ->add(
                'kyc_documents_types',
                RepeaterField::class,
                RepeaterFieldOption::make()
                    ->label(trans('Kyc Documents Type'))
                    ->value(setting('kyc_documents_types', []))
                    ->fields($fieldName)
            )
            ->add('invoice_prefix',
                TextField::class,
                TextFieldOption::make()->label(__('Invoice Prefix'))
                    ->value(setting('invoice_prefix'))
                    ->helperText(__('Ingrese el prefijo de sus facturas'))
            )
            ->add(
                'invoices_currencies',
                RepeaterField::class,
                RepeaterFieldOption::make()
                    ->label(trans('Invoices Currencies'))
                    ->value(setting('invoices_currencies', []))
                    ->fields($currencyFields)
            );
    }
}
