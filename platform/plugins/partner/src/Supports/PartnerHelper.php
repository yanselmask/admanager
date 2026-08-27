<?php

namespace Botble\Partner\Supports;

use Botble\Member\Models\Member;
use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Partner\Models\PartnerNetwork;

class PartnerHelper
{
    public static function isPartner(?Member $member): bool
    {
        return $member?->getAttribute('role') === PartnerRoleEnum::PARTNER;
    }

    public static function isCreator(?Member $member): bool
    {
        return $member !== null && ! self::isPartner($member);
    }

    /**
     * Resuelve la comisión aplicable tomando el primer valor no nulo:
     * comisión de la network asignada → comisión del partner → setting global → 0.
     *
     * El resultado se acota a [0, 100]: un valor fuera de rango almacenado en base de datos
     * produciría una ganancia mayor que la parte que recibe la plataforma.
     */
    public static function resolveCommission(?Member $partner, ?PartnerNetwork $network = null): float
    {
        $commission = $network?->commission
            ?? $partner?->getAttribute('commission')
            ?? setting('partner_percentage_default');

        return self::clamp((float) $commission);
    }

    protected static function clamp(float $commission): float
    {
        return max(0.0, min(100.0, $commission));
    }
}
