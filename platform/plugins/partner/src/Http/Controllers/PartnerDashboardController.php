<?php

namespace Botble\Partner\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Member\Models\Member;
use Botble\Partner\Forms\PartnerSettingForm;
use Botble\Partner\Services\PartnerEarningService;
use Botble\Theme\Facades\Theme;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PartnerDashboardController extends BaseController
{
    public function __construct(protected PartnerEarningService $earnings) {}

    public function index(Request $request): View
    {
        $partner = $this->partner();
        $period = $this->earnings->resolvePeriod($request->query('period'));

        $this->pageTitle(trans('plugins/partner::partner.dashboard.title'));

        return $this->view('index', [
            'partner' => $partner,
            'period' => $period,
            'periods' => PartnerEarningService::PERIODS,
            'metrics' => $this->earnings->forPartner($partner, $period),
            'networks' => $this->earnings->networksOf($partner),
            'visibleMetrics' => $this->visibleMetrics(),
            'series' => $this->earnings->seriesFor($partner),
        ]);
    }

    public function accounts(Request $request): View
    {
        $partner = $this->partner();
        $period = $this->earnings->resolvePeriod($request->query('period'));

        $this->pageTitle(trans('plugins/partner::partner.dashboard.accounts'));

        return $this->view('accounts', [
            'partner' => $partner,
            'period' => $period,
            'periods' => PartnerEarningService::PERIODS,
            'accounts' => $this->earnings->byNetwork($partner, $period),
            'visibleMetrics' => $this->visibleMetrics(),
        ]);
    }

    public function domains(Request $request): View
    {
        $partner = $this->partner();
        $period = $this->earnings->resolvePeriod($request->query('period'));
        $networks = $this->earnings->networksOf($partner);
        $selected = $this->selectedNetwork($request);

        $domains = $this->earnings
            ->domainsQuery($this->networkCodesToQuery($networks->keys()->all(), $selected))
            ->paginate(20)
            ->appends($request->only(['period', 'network']));

        $this->pageTitle(trans('plugins/partner::partner.dashboard.domains'));

        return $this->view('domains', [
            'partner' => $partner,
            'period' => $period,
            'periods' => PartnerEarningService::PERIODS,
            'networks' => $networks,
            'selectedNetwork' => $selected,
            'domains' => $domains,
            'metricsOf' => fn ($domain) => $this->earnings->forDomains($partner, [$domain], $period, $networks),
            'visibleMetrics' => $this->visibleMetrics(),
        ]);
    }

    protected function partner(): Member
    {
        return auth('member')->user();
    }

    /**
     * Network pedida por query string. `null` significa «todas las suyas».
     */
    protected function selectedNetwork(Request $request): ?string
    {
        $requested = $request->query('network');

        return $requested === null || $requested === '' || $requested === 'any'
            ? null
            : (string) $requested;
    }

    /**
     * Networks que se consultan realmente. Un filtro por una network que el partner no
     * tiene asignada no devuelve nada, en lugar de ignorarse y mostrarle todas las suyas.
     *
     * @param  array<int, string>  $ownedCodes
     * @return array<int, string>
     */
    protected function networkCodesToQuery(array $ownedCodes, ?string $selected): array
    {
        if ($selected === null) {
            return $ownedCodes;
        }

        // Los network codes son numéricos, y PHP convierte a entero las claves de array
        // que lo parecen: `keyBy('network_code')` deja claves int, no string. Se comparan
        // como cadenas para que la comparación estricta no falle siempre.
        $owned = array_map('strval', $ownedCodes);

        return in_array($selected, $owned, true) ? [$selected] : [];
    }

    /**
     * @return array<string, bool>
     */
    protected function visibleMetrics(): array
    {
        $visible = [];

        foreach (array_keys(PartnerSettingForm::METRICS) as $setting) {
            $visible[str_replace('_partner', '', $setting)] = (bool) setting($setting, true);
        }

        return $visible;
    }

    /**
     * Resuelve la vista en el tema activo y cae a las del plugin si el tema no la define,
     * de modo que el panel funcione en cualquier tema sin copiar archivos.
     */
    protected function view(string $name, array $data): View
    {
        $themeView = Theme::getThemeNamespace('views.partner.dashboard.'.$name);

        return view(
            view()->exists($themeView) ? $themeView : 'plugins/partner::themes.dashboard.'.$name,
            $data
        );
    }
}
