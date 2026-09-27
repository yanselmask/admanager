<?php

namespace Botble\Partner\Http\Requests;

use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Partner\Forms\PartnerSettingForm;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PartnerRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'member_id' => ['required', 'exists:members,id'],
            'role' => ['required', Rule::in(PartnerRoleEnum::values())],
            'commission' => ['nullable', 'numeric', 'between:0,100'],
        ];

        foreach (array_keys(PartnerSettingForm::METRICS) as $setting) {
            $rules['visibility_'.$setting] = ['nullable', Rule::in(['0', '1'])];
        }

        return $rules;
    }

    /**
     * Preferencias de visibilidad elegidas para el partner; las que quedan en
     * "configuración general" no se guardan.
     *
     * @return array<string, bool>
     */
    public function visibilityOverrides(): array
    {
        $overrides = [];

        foreach (array_keys(PartnerSettingForm::METRICS) as $setting) {
            $value = $this->input('visibility_'.$setting);

            if ($value === '0' || $value === '1') {
                $overrides[$setting] = $value === '1';
            }
        }

        return $overrides;
    }

    public function attributes(): array
    {
        return [
            'member_id' => trans('plugins/partner::partner.member'),
            'commission' => trans('plugins/partner::partner.networks.commission'),
        ];
    }
}
