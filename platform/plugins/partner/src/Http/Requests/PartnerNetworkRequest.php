<?php

namespace Botble\Partner\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Member\Models\Member;
use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Partner\Models\PartnerNetwork;
use Botble\Partner\Supports\AdmanagerNetworks;
use Botble\Support\Http\Requests\Request;
use Closure;
use Illuminate\Validation\Rule;

class PartnerNetworkRequest extends Request
{
    public function rules(): array
    {
        return [
            'member_id' => ['required', 'exists:members,id', $this->memberMustBeAPartner()],
            'network_code' => [
                'required',
                Rule::in(AdmanagerNetworks::codes()),
                $this->networkMustNotBeTaken(),
            ],
            'commission' => ['nullable', 'numeric', 'between:0,100'],
            'status' => ['nullable', Rule::in(BaseStatusEnum::values())],
        ];
    }

    /**
     * Una network solo puede pertenecer a un partner: si dos partners compartieran
     * la misma cuenta, sus ganancias se contarían dos veces.
     */
    protected function networkMustNotBeTaken(): Closure
    {
        return function (string $attribute, mixed $value, Closure $fail): void {
            $existing = PartnerNetwork::query()
                ->where('network_code', $value)
                ->when($this->route('partner_network'), fn ($query, $current) => $query->whereKeyNot($current))
                ->with('member')
                ->first();

            if ($existing) {
                $fail(trans('plugins/partner::partner.networks.already_assigned', [
                    'code' => $value,
                    'partner' => $existing->member?->name ?: '#'.$existing->member_id,
                ]));
            }
        };
    }

    protected function memberMustBeAPartner(): Closure
    {
        return function (string $attribute, mixed $value, Closure $fail): void {
            $member = Member::query()->find($value);

            if ($member && $member->getAttribute('role') !== PartnerRoleEnum::PARTNER) {
                $fail(trans('plugins/partner::partner.networks.member_not_partner'));
            }
        };
    }
}
