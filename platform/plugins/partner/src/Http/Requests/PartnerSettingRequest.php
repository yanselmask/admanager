<?php

namespace Botble\Partner\Http\Requests;

use Botble\Partner\Services\PartnerEarningService;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PartnerSettingRequest extends Request
{
    public function rules(): array
    {
        return [
            'partner_percentage_default' => ['required', 'numeric', 'between:0,100'],
            'partner_earning_base' => [
                'required',
                Rule::in([PartnerEarningService::BASE_PLATFORM_NET, PartnerEarningService::BASE_GROSS]),
            ],
            'earning_partner' => ['nullable'],
            'impressions_partner' => ['nullable'],
            'clicks_partner' => ['nullable'],
            'ctrs_partner' => ['nullable'],
            'ecpms_partner' => ['nullable'],
        ];
    }
}
