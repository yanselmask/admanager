<?php

namespace Botble\Partner\Services;

use Botble\Domain\Models\Domain;
use Botble\Member\Models\Member;
use Botble\Partner\Data\PartnerMetrics;
use Botble\Partner\Models\PartnerNetwork;
use Botble\Partner\Supports\PartnerHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class PartnerEarningService
{
    /**
     * Los importes de Google Ad Manager llegan expresados en micros.
     */
    public const MICROS = 1000000;

    public const DEFAULT_PERIOD = 'today';

    public const BASE_PLATFORM_NET = 'platform_net';

    public const BASE_GROSS = 'gross';

    /**
     * Claves de periodo válidas. Reflejan las opciones del repeater de
     * `Botble\Admanager\Forms\AdmanagerSettingForm`, que es lo que alimenta
     * las columnas JSON de `domains`.
     */
    public const PERIODS = [
        'today',
        'yesterday',
        'this_week',
        'last_week',
        'this_month',
        'last_month',
        'last_2_months',
        'last_3_months',
        'last_6_months',
        'last_9_months',
        'this_year',
    ];

    /**
     * Columnas mínimas necesarias para el cálculo. Traer `select *` arrastraría
     * todas las columnas JSON de cada dominio sin usarlas.
     */
    protected const DOMAIN_COLUMNS = [
        'id',
        'url',
        'name',
        'status',
        'network_code',
        'commissions',
        'commissions_network',
        'earnings',
        'impressions',
        'clicks',
    ];

    public function forPartner(Member $partner, ?string $period = null): PartnerMetrics
    {
        $period = $this->resolvePeriod($period);
        $networks = $this->networksOf($partner);

        if ($networks->isEmpty()) {
            return PartnerMetrics::zero();
        }

        return $this->aggregate($partner, $networks, $this->domainsOf($networks->keys()->all()), $period);
    }

    /**
     * Métricas desglosadas por network asignada. Las networks sin dominios
     * aparecen igualmente, con todas sus métricas en cero.
     *
     * @return Collection<string, array{network: PartnerNetwork, metrics: PartnerMetrics, domains_count: int}>
     */
    public function byNetwork(Member $partner, ?string $period = null): Collection
    {
        $period = $this->resolvePeriod($period);
        $networks = $this->networksOf($partner);

        if ($networks->isEmpty()) {
            return collect();
        }

        $domainsByNetwork = $this->domainsOf($networks->keys()->all())->groupBy('network_code');

        return $networks->map(function (PartnerNetwork $network) use ($partner, $domainsByNetwork, $period) {
            $domains = $domainsByNetwork->get($network->network_code, collect());

            return [
                'network' => $network,
                'metrics' => $this->aggregate($partner, collect([$network->network_code => $network]), $domains, $period),
                'domains_count' => $domains->count(),
            ];
        });
    }

    /**
     * Dominios de las networks indicadas. Es el único punto que consulta `domains`,
     * y devuelve todos los dominios de la network con independencia de su `member_id`:
     * el partner ve las cuentas que aportó, tengan creador asignado o no.
     */
    public function domainsOf(array $networkCodes): EloquentCollection
    {
        return $this->domainsQuery($networkCodes)->get(self::DOMAIN_COLUMNS);
    }

    /**
     * Consulta base de los dominios de unas networks, para poder paginar en el panel.
     * Sin networks asignadas devuelve una consulta que no arroja nada.
     */
    public function domainsQuery(array $networkCodes): Builder
    {
        if ($networkCodes === []) {
            return Domain::query()->whereRaw('1 = 0');
        }

        return Domain::query()
            ->whereIn('network_code', $networkCodes)
            ->select(self::DOMAIN_COLUMNS)
            ->orderBy('url');
    }

    public function resolvePeriod(?string $period): string
    {
        return in_array($period, self::PERIODS, true) ? $period : self::DEFAULT_PERIOD;
    }

    /**
     * @return Collection<string, PartnerNetwork>
     */
    public function networksOf(Member $partner): Collection
    {
        return $partner->partnerNetworks()->get()->keyBy('network_code');
    }

    /**
     * Métricas de un conjunto concreto de dominios. Permite calcular la fila de un
     * dominio suelto sin repetir la consulta, pasándole las networks ya cargadas.
     *
     * @param  iterable<Domain>  $domains
     * @param  Collection<string, PartnerNetwork>|null  $networks
     */
    public function forDomains(Member $partner, iterable $domains, ?string $period = null, ?Collection $networks = null): PartnerMetrics
    {
        return $this->aggregate(
            $partner,
            $networks ?? $this->networksOf($partner),
            $domains,
            $this->resolvePeriod($period)
        );
    }

    /**
     * Serie de una métrica a lo largo de todos los periodos, cargando los dominios
     * una sola vez en lugar de una consulta por periodo.
     *
     * @return array<string, float>
     */
    public function seriesFor(Member $partner, string $metric = 'earning'): array
    {
        $networks = $this->networksOf($partner);

        if ($networks->isEmpty()) {
            return array_fill_keys(self::PERIODS, 0.0);
        }

        $domains = $this->domainsOf($networks->keys()->all());

        $series = [];

        foreach (self::PERIODS as $period) {
            $series[$period] = $this->aggregate($partner, $networks, $domains, $period)->{$metric};
        }

        return $series;
    }

    /**
     * @param  Collection<string, PartnerNetwork>  $networks
     * @param  iterable<Domain>  $domains
     */
    protected function aggregate(Member $partner, Collection $networks, iterable $domains, string $period): PartnerMetrics
    {
        $earning = 0.0;
        $impressions = 0.0;
        $clicks = 0.0;

        foreach ($domains as $domain) {
            $earning += $this->earningOf($domain, $partner, $networks->get($domain->network_code), $period);
            $impressions += $this->valueOf($domain->impressions, $period);
            $clicks += $this->valueOf($domain->clicks, $period);
        }

        return PartnerMetrics::fromTotals($earning, $impressions, $clicks);
    }

    /**
     * Ganancia que corresponde al partner por un dominio: su comisión aplicada
     * sobre la base configurada en `partner_earning_base`.
     */
    protected function earningOf(Domain $domain, Member $partner, ?PartnerNetwork $network, string $period): float
    {
        $base = $this->baseOf($domain, $this->valueOf($domain->earnings, $period) / self::MICROS);

        return $base * PartnerHelper::resolveCommission($partner, $network) / 100;
    }

    /**
     * Base sobre la que se aplica la comisión del partner.
     *
     * - `gross`: el revenue bruto del reporte de Ad Manager.
     * - `platform_net` (por defecto): lo que la plataforma recibe realmente, es decir
     *   la comisión total menos la parte que se queda la network. Si `commissions_network`
     *   fuese mayor que `commissions`, la base se trunca a 0 en lugar de restar de otros dominios.
     */
    protected function baseOf(Domain $domain, float $raw): float
    {
        if (setting('partner_earning_base', self::BASE_PLATFORM_NET) === self::BASE_GROSS) {
            return $raw;
        }

        $commissions = (float) ($domain->commissions ?? setting('percentage_default', 0));
        $networkCommissions = (float) ($domain->commissions_network ?? 0);

        return $raw * max(0.0, $commissions - $networkCommissions) / 100;
    }

    /**
     * Lee una clave de periodo de una columna JSON de `domains`. Un periodo que el
     * dominio todavía no tiene registrado aporta 0, no un error.
     */
    protected function valueOf(?array $values, string $period): float
    {
        return (float) ($values[$period] ?? 0);
    }
}
