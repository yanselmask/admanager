<?php

namespace Botble\Partner\Supports;

use Botble\Member\Models\Member;
use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Partner\Forms\PartnerSettingForm;
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

    /**
     * Qué datos ve el partner en su panel, con la clave corta que usan las vistas
     * (`domains`, `earning`, …). Cada uno toma la preferencia propia del partner si
     * el admin la fijó y, si no, la configuración general.
     *
     * @return array<string, bool>
     */
    public static function visibleMetrics(?Member $partner): array
    {
        $overrides = self::visibilityOverrides($partner);
        $visible = [];

        foreach (array_keys(PartnerSettingForm::METRICS) as $setting) {
            $visible[str_replace('_partner', '', $setting)] = $overrides[$setting] ?? (bool) setting($setting, true);
        }

        return $visible;
    }

    /**
     * Preferencias de visibilidad fijadas para este partner, por clave de setting.
     *
     * @return array<string, bool>
     */
    public static function visibilityOverrides(?Member $partner): array
    {
        $stored = json_decode((string) $partner?->getAttribute('partner_visibility'), true);

        if (! is_array($stored)) {
            return [];
        }

        return collect($stored)
            ->only(array_keys(PartnerSettingForm::METRICS))
            ->map(fn ($value) => (bool) $value)
            ->all();
    }

    protected static function clamp(float $commission): float
    {
        return max(0.0, min(100.0, $commission));
    }
}
