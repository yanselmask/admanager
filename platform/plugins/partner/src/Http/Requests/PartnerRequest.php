<?php

namespace Botble\Partner\Http\Requests;

use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PartnerRequest extends Request
{
    public function rules(): array
    {
        return [
            'member_id' => ['required', 'exists:members,id'],
            'role' => ['required', Rule::in(PartnerRoleEnum::values())],
            'commission' => ['nullable', 'numeric', 'between:0,100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'member_id' => trans('plugins/partner::partner.member'),
            'commission' => trans('plugins/partner::partner.networks.commission'),
        ];
    }
}
