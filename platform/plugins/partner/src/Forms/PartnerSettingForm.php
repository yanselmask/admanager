<?php

namespace Botble\Partner\Forms;

use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Partner\Http\Requests\PartnerSettingRequest;
use Botble\Partner\Services\PartnerEarningService;
use Botble\Setting\Forms\SettingForm;

class PartnerSettingForm extends SettingForm
{
    /**
     * Métricas del panel del partner y su setting de visibilidad. Todas vienen
     * activadas por defecto: un panel recién configurado muestra las cinco.
     */
    public const METRICS = [
        'earning_partner' => 'dashboard.earning',
        'impressions_partner' => 'dashboard.impressions',
        'clicks_partner' => 'dashboard.clicks',
        'ctrs_partner' => 'dashboard.ctr',
        'ecpms_partner' => 'dashboard.ecpm',
    ];

    public function setup(): void
    {
        parent::setup();

        $this
            ->setSectionTitle(trans('plugins/partner::partner.settings.title'))
            ->setSectionDescription(trans('plugins/partner::partner.settings.description'))
            ->setValidatorClass(PartnerSettingRequest::class)
            ->add(
                'partner_percentage_default',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/partner::partner.settings.percentage_default'))
                    ->value(setting('partner_percentage_default'))
                    ->required()
                    ->helperText(trans('plugins/partner::partner.settings.percentage_default_helper'))
            )
            ->add(
                'partner_earning_base',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/partner::partner.settings.earning_base'))
                    ->choices([
                        PartnerEarningService::BASE_PLATFORM_NET => trans('plugins/partner::partner.settings.earning_base_platform_net'),
                        PartnerEarningService::BASE_GROSS => trans('plugins/partner::partner.settings.earning_base_gross'),
                    ])
                    ->selected(setting('partner_earning_base', PartnerEarningService::BASE_PLATFORM_NET))
                    ->required()
                    ->helperText(trans('plugins/partner::partner.settings.earning_base_helper'))
            );

        foreach (self::METRICS as $key => $label) {
            $this->add(
                $key,
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(trans('plugins/partner::partner.'.$label))
                    ->value(setting($key, true))
            );
        }
    }
}
