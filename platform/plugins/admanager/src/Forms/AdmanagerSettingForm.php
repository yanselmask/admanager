<?php

namespace Botble\Admanager\Forms;

use Botble\Admanager\Http\Requests\AdmanagerRequest;
use Botble\Base\Forms\FieldOptions\MediaFileFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\MediaFileField;
use Botble\Base\Forms\Fields\OnOffCheckboxField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Member\Http\Requests\Settings\MemberSettingRequest;
use Botble\Setting\Forms\SettingForm;
use Google\Service\Transcoder\TextInput;

class AdmanagerSettingForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->setSectionTitle(trans('Google Ad Manager'))
            ->setSectionDescription(trans('Configure your Google Ad manager'))
            ->setValidatorClass(AdmanagerRequest::class)
            ->add('admanager_network_code',
                TextField::class,
                TextFieldOption::make()->label(__('Ad Manager Network Code'))
                    ->value(setting('admanager_network_code'))
                    ->helperText(__('El código de red es el código único con el que se identifica su red de Ad Manager.'))
                    ->required()
            )
            ->add('admanager_network_name',
                TextField::class,
                TextFieldOption::make()->label(__('Ad Manager Network Name'))
                    ->value(setting('admanager_network_name'))
                    ->helperText(__('Nombre visible de esta red. Si utiliza varias cuentas, puede ayudarle a distinguirlas.'))
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
            );
    }
}
