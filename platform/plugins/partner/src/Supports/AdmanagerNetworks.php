<?php

namespace Botble\Partner\Supports;

use Botble\Admanager\Services\Admanager;

/**
 * Acceso a las networks configuradas en el plugin `admanager`. Centraliza aquí la
 * lectura para no repetir el parseo del repeater `admanager_networks`, que hoy está
 * duplicado en `DomainForm` y `DomainRequest`.
 */
class AdmanagerNetworks
{
    /**
     * @return array<string, string> network_code => nombre
     */
    public static function all(): array
    {
        if (! is_plugin_active('admanager')) {
            return [];
        }

        return array_map('strval', app(Admanager::class)->getNetworksCodeAndName());
    }

    /**
     * @return array<int, string>
     */
    public static function codes(): array
    {
        return array_map('strval', array_keys(self::all()));
    }

    public static function name(string $networkCode): string
    {
        return self::all()[$networkCode] ?? $networkCode;
    }
}
