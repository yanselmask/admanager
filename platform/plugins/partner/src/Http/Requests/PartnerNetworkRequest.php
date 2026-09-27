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
            'starts_at' => ['nullable', 'date'],
            'commission' => ['nullable', 'numeric', 'between:0,100'],
            'status' => ['nullable', Rule::in(BaseStatusEnum::values())],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->input('starts_at') === '') {
            $this->merge(['starts_at' => null]);
        }
    }

    /**
     * Una network puede cambiar de partner a partir de una fecha, pero no puede tener dos
     * asignaciones que empiecen el mismo día (ni dos generales): sus ganancias se
     * contarían dos veces.
     */
    protected function networkMustNotBeTaken(): Closure
    {
        return function (string $attribute, mixed $value, Closure $fail): void {
            $startsAt = $this->input('starts_at');

            $existing = PartnerNetwork::query()
                ->where('network_code', $value)
                ->when(
                    $startsAt,
                    fn ($query) => $query->whereDate('starts_at', $startsAt),
                    fn ($query) => $query->whereNull('starts_at')
                )
                ->when($this->route('partner_network'), fn ($query, $current) => $query->whereKeyNot($current))
                ->with('member')
                ->first();

            if (! $existing) {
                return;
            }

            $owner = $existing->member?->name ?: '#'.$existing->member_id;

            $fail($startsAt
                ? "La cuenta {$value} ya está asignada a {$owner} desde esa misma fecha."
                : "La cuenta {$value} ya tiene una asignación general ({$owner}). Pon una fecha de inicio para traspasarla.");
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
