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
                    ->selected(json_decode(setting('earning_member')))
            )
            ->add('impressions_member',
                \Botble\Base\Forms\Fields\MultiCheckListField::class,
                MultiChecklistFieldOption::make()->label(__('Impressions'))
                    ->choices($choices)
                    ->multiple()
                    ->selected(json_decode(setting('impressions_member')))
            )
            ->add('clicks_member',
                \Botble\Base\Forms\Fields\MultiCheckListField::class,
                MultiChecklistFieldOption::make()->label(__('Clicks'))
                    ->choices($choices)
                    ->multiple()
                    ->selected(json_decode(setting('clicks_member')))
            )
            ->add('ctrs_member',
                \Botble\Base\Forms\Fields\MultiCheckListField::class,
                MultiChecklistFieldOption::make()->label(__('Ctrs'))
                    ->choices($choices)
                    ->multiple()
                    ->selected(json_decode(setting('ctrs_member')))
            )
            ->add('ecpms_member',
                \Botble\Base\Forms\Fields\MultiCheckListField::class,
                MultiChecklistFieldOption::make()->label(__('Ecpms'))
                    ->multiple()
                    ->choices($choices)
                    ->selected(json_decode(setting('ecpms_member')))
            )
            ->add('support_number',
                TextField::class,
                TextFieldOption::make()->label(__('Support Number'))
                    ->value(setting('support_number'))
                    ->required()
                    ->helperText(__('Escriba un número de soporte'))
            )
            ->add('support_message',
                TextareaField::class,
                TextareaFieldOption::make()->label(__('Support Message'))
                    ->value(setting('support_message'))
                    ->required()
                    ->helperText(__('Escriba un mensaje por defecto'))
            )
            ->add('member_kyc_is_required',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(__('KYC is required'))
                    ->value(setting('member_kyc_is_required', false))
            );
    }
}
