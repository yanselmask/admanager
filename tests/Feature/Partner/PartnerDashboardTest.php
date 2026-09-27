<?php

namespace Tests\Feature\Partner;

use Botble\Domain\Models\Domain;
use Botble\Member\Models\Member;
use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Partner\Models\PartnerNetwork;
use Botble\Partner\Services\PartnerEarningService;
use Botble\Setting\Facades\Setting;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PartnerDashboardTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Setting::set('partner_earning_base', PartnerEarningService::BASE_PLATFORM_NET)->save();
        Setting::set('percentage_default', 12)->save();
        Setting::set('admanager_networks', json_encode([
            [['key' => 'name', 'value' => 'Cuenta A'], ['key' => 'code', 'value' => '123456']],
            [['key' => 'name', 'value' => 'Cuenta B'], ['key' => 'code', 'value' => '789012']],
        ]))->save();
    }

    protected function tearDown(): void
    {
        foreach (['partner_earning_base', 'percentage_default', 'admanager_networks', 'ecpms_partner', 'clicks_partner', 'domains_partner', 'theme'] as $key) {
            Setting::forget($key);
        }

        parent::tearDown();
    }

    // --- Panel ---------------------------------------------------------------------------

    public function test_the_dashboard_shows_the_partner_metrics(): void
    {
        $partner = $this->partnerWith('123456', commission: 10);
        $this->domain('123456', earnings: 100_000_000, impressions: 10000, clicks: 250);

        $this->actingAs($partner, 'member')
            ->get(route('partner.dashboard'))
            ->assertOk()
            ->assertSee('4.50')          // 100 x (60-15)% x 10% con commissions del dominio
            ->assertSee('10,000')
            ->assertSee('250');
    }

    public function test_a_partner_without_networks_sees_zeros_and_a_notice(): void
    {
        $response = $this->actingAs($this->partner(), 'member')->get(route('partner.dashboard'));

        $response->assertOk()
            ->assertSee(trans('plugins/partner::partner.dashboard.no_networks'))
            ->assertSee('0.00');
    }

    public function test_the_period_filter_changes_the_figures(): void
    {
        $partner = $this->partnerWith('123456', commission: 10);
        $this->domain('123456', earnings: 100_000_000, period: 'this_month');

        // La vista incluye la serie de todos los periodos, así que se comprueban las
        // métricas del periodo activo, no la presencia del número en el HTML.
        $this->actingAs($partner, 'member')
            ->get(route('partner.dashboard', ['period' => 'this_month']))
            ->assertOk()
            ->assertViewHas('period', 'this_month')
            ->assertViewHas('metrics', fn ($metrics) => abs($metrics->earning - 4.50) < 0.0001);

        $this->actingAs($partner, 'member')
            ->get(route('partner.dashboard', ['period' => 'today']))
            ->assertOk()
            ->assertViewHas('period', 'today')
            ->assertViewHas('metrics', fn ($metrics) => $metrics->earning === 0.0);
    }

    // --- Cuentas -------------------------------------------------------------------------

    public function test_the_accounts_view_lists_one_row_per_network(): void
    {
        $partner = $this->partner();
        $this->network($partner, '123456');
        $this->network($partner, '789012');

        $this->actingAs($partner, 'member')
            ->get(route('partner.accounts'))
            ->assertOk()
            ->assertSee('Cuenta A')
            ->assertSee('Cuenta B')
            ->assertSee('123456')
            ->assertSee('789012');
    }

    public function test_the_breakdown_matches_the_dashboard_total(): void
    {
        $partner = $this->partner();
        $this->network($partner, '123456', commission: 10);
        $this->network($partner, '789012', commission: 15);
        $this->domain('123456', earnings: 100_000_000);
        $this->domain('789012', earnings: 200_000_000, url: 'second.test');

        $service = app(PartnerEarningService::class);

        $this->assertEqualsWithDelta(
            $service->forPartner($partner, 'today')->earning,
            $service->byNetwork($partner, 'today')->sum(fn (array $r) => $r['metrics']->earning),
            0.0001
        );
    }

    public function test_a_network_without_domains_is_still_listed(): void
    {
        $partner = $this->partnerWith('123456');

        $this->actingAs($partner, 'member')
            ->get(route('partner.accounts'))
            ->assertOk()
            ->assertSee('Cuenta A')
            ->assertSee('0.00');
    }

    // --- Dominios ------------------------------------------------------------------------

    public function test_the_domains_view_lists_the_domains_of_the_networks(): void
    {
        $partner = $this->partnerWith('123456');
        $domain = $this->domain('123456');

        $this->actingAs($partner, 'member')
            ->get(route('partner.domains'))
            ->assertOk()
            ->assertSee($domain->url)
            ->assertSee('Cuenta A');
    }

    public function test_the_domains_view_can_be_filtered_by_network(): void
    {
        $partner = $this->partner();
        $this->network($partner, '123456');
        $this->network($partner, '789012');

        $a = $this->domain('123456', url: 'a.test');
        $b = $this->domain('789012', url: 'b.test');

        $this->actingAs($partner, 'member')
            ->get(route('partner.domains', ['network' => '123456']))
            ->assertOk()
            ->assertSee($a->url)
            ->assertDontSee($b->url);
    }

    public function test_the_pagination_keeps_the_period_and_network_filters(): void
    {
        $partner = $this->partnerWith('123456');

        for ($i = 0; $i < 25; $i++) {
            $this->domain('123456', url: "site{$i}.test");
        }

        $response = $this->actingAs($partner, 'member')
            ->get(route('partner.domains', ['period' => 'this_month', 'network' => '123456']));

        $response->assertOk()
            ->assertSee('period=this_month', false)
            ->assertSee('network=123456', false);
    }

    // --- Visibilidad ----------------------------------------------------------------------

    public function test_a_disabled_metric_is_hidden(): void
    {
        $partner = $this->partnerWith('123456');
        $this->domain('123456', earnings: 100_000_000, impressions: 10000);

        $this->actingAs($partner, 'member')
            ->get(route('partner.dashboard'))
            ->assertOk()
            ->assertSee(trans('plugins/partner::partner.dashboard.ecpm'));

        Setting::set('ecpms_partner', false)->save();

        $this->actingAs($partner, 'member')
            ->get(route('partner.dashboard'))
            ->assertOk()
            ->assertDontSee(trans('plugins/partner::partner.dashboard.ecpm'));
    }

    public function test_the_admin_can_hide_the_domains_from_the_panel(): void
    {
        $partner = $this->partnerWith('123456');
        $domainsColumn = '<th class="num">'.trans('plugins/partner::partner.networks.domains_count').'</th>';

        $this->actingAs($partner, 'member')
            ->get(route('partner.accounts'))
            ->assertOk()
            ->assertSee($domainsColumn, false);

        Setting::set('domains_partner', false)->save();

        $this->actingAs($partner, 'member')
            ->get(route('partner.accounts'))
            ->assertOk()
            ->assertDontSee($domainsColumn, false);

        $this->actingAs($partner, 'member')
            ->get(route('partner.domains'))
            ->assertRedirect(route('partner.dashboard'));
    }

    public function test_hidden_domains_drop_out_of_the_partner_menu(): void
    {
        Setting::set('domains_partner', false)->save();

        $this->assertNotContains('cms-partner-domains', $this->menuFor($this->partnerWith('123456')));
    }

    public function test_a_partner_override_hides_a_metric_only_for_that_partner(): void
    {
        $hidden = $this->partnerWith('123456');
        $hidden->setAttribute('partner_visibility', json_encode(['ecpms_partner' => false]))->save();
        $other = $this->partnerWith('789012');
        $ecpm = trans('plugins/partner::partner.dashboard.ecpm');

        $this->actingAs($hidden, 'member')
            ->get(route('partner.dashboard'))
            ->assertOk()
            ->assertDontSee($ecpm);

        $this->actingAs($other, 'member')
            ->get(route('partner.dashboard'))
            ->assertOk()
            ->assertSee($ecpm);
    }

    public function test_a_partner_override_shows_a_metric_the_general_setting_hides(): void
    {
        Setting::set('ecpms_partner', false)->save();

        $partner = $this->partnerWith('123456');
        $partner->setAttribute('partner_visibility', json_encode(['ecpms_partner' => true]))->save();

        $this->actingAs($partner, 'member')
            ->get(route('partner.dashboard'))
            ->assertOk()
            ->assertSee(trans('plugins/partner::partner.dashboard.ecpm'));
    }

    public function test_a_partner_override_can_hide_the_domains(): void
    {
        $partner = $this->partnerWith('123456');
        $partner->setAttribute('partner_visibility', json_encode(['domains_partner' => false]))->save();

        $this->assertNotContains('cms-partner-domains', $this->menuFor($partner));

        $this->actingAs($partner, 'member')
            ->get(route('partner.domains'))
            ->assertRedirect(route('partner.dashboard'));
    }

    public function test_the_admin_saves_and_clears_the_partner_overrides(): void
    {
        $partner = $this->partnerWith('123456');
        $admin = $this->admin();
        $payload = [
            'member_id' => $partner->getKey(),
            'role' => PartnerRoleEnum::PARTNER,
            'commission' => '',
        ];

        $this->actingAs($admin)
            ->post(route('partner.edit.update', $partner->getKey()), $payload + [
                'visibility_domains_partner' => '0',
                'visibility_ecpms_partner' => '1',
                'visibility_clicks_partner' => '',
            ])
            ->assertSessionHasNoErrors();

        $this->assertSame(
            ['domains_partner' => false, 'ecpms_partner' => true],
            json_decode($partner->fresh()->getAttribute('partner_visibility'), true)
        );

        $this->actingAs($admin)
            ->get(route('partner.edit', $partner->getKey()))
            ->assertOk()
            ->assertSee('name="visibility_domains_partner"', false);

        $this->actingAs($admin)
            ->post(route('partner.edit.update', $partner->getKey()), $payload)
            ->assertSessionHasNoErrors();

        $this->assertNull($partner->fresh()->getAttribute('partner_visibility'));
    }

    public function test_an_invalid_override_is_rejected(): void
    {
        $partner = $this->partnerWith('123456');

        $this->actingAs($this->admin())
            ->post(route('partner.edit.update', $partner->getKey()), [
                'member_id' => $partner->getKey(),
                'role' => PartnerRoleEnum::PARTNER,
                'visibility_domains_partner' => 'maybe',
            ])
            ->assertSessionHasErrors('visibility_domains_partner');
    }

    public function test_the_dashboard_can_be_narrowed_to_one_site(): void
    {
        $partner = $this->partnerWith('123456', commission: 10);
        $first = $this->domain('123456', earnings: 100_000_000, impressions: 1000, url: 'uno.test');
        $this->domain('123456', earnings: 300_000_000, impressions: 3000, url: 'dos.test');

        $all = $this->actingAs($partner, 'member')->get(route('partner.dashboard'));
        $all->assertOk()->assertViewHas('sites', fn ($sites) => $sites->count() === 2);
        $this->assertEquals(4000, $all->viewData('metrics')->impressions);

        $one = $this->actingAs($partner, 'member')->get(route('partner.dashboard', ['domain' => $first->url]));
        $one->assertOk()->assertViewHas('selectedSite', fn ($site) => $site?->is($first));
        $this->assertEquals(1000, $one->viewData('metrics')->impressions);
        $this->assertEquals(4.5, $one->viewData('metrics')->earning);
        $this->assertEquals(4.5, $one->viewData('series')['today']);
    }

    public function test_a_site_outside_the_partner_networks_is_ignored(): void
    {
        $partner = $this->partnerWith('123456');
        $this->domain('123456', impressions: 1000, url: 'propio.test');
        $foreign = $this->domain('999999', impressions: 5000, url: 'ajeno.test');

        $response = $this->actingAs($partner, 'member')->get(route('partner.dashboard', ['domain' => $foreign->url]));

        $response->assertOk()->assertViewHas('selectedSite', null);
        $this->assertEquals(1000, $response->viewData('metrics')->impressions);
    }

    public function test_the_site_filter_is_not_offered_when_domains_are_hidden(): void
    {
        Setting::set('domains_partner', false)->save();

        $partner = $this->partnerWith('123456');
        $site = $this->domain('123456', impressions: 1000, url: 'uno.test');

        $this->actingAs($partner, 'member')
            ->get(route('partner.dashboard', ['domain' => $site->url]))
            ->assertOk()
            ->assertViewHas('sites', fn ($sites) => $sites->isEmpty())
            ->assertViewHas('selectedSite', null);
    }

    public function test_the_admin_partner_list_counts_the_assigned_networks(): void
    {
        $partner = $this->partnerWith('123456');
        $this->network($partner, '789012');

        $response = $this->actingAs($this->admin())
            ->postJson(route('partner.index'), ['draw' => 1, 'start' => 0, 'length' => 50], ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk();

        $row = collect($response->json('data'))->firstWhere('id', $partner->getKey());

        $this->assertNotNull($row);
        $this->assertEquals(2, $row['partner_networks_count']);
    }

    public function test_the_panel_offers_the_same_periods_as_the_creator_panel(): void
    {
        $partner = $this->partnerWith('123456');

        $response = $this->actingAs($partner, 'member')->get(route('partner.dashboard', ['period' => 'last_week']));

        $response->assertOk()
            ->assertViewHas('periods', ['today', 'yesterday', 'this_week', 'this_month', 'last_month'])
            ->assertViewHas('period', 'today')
            ->assertViewHas('series', fn (array $series) => array_keys($series) === ['today', 'yesterday', 'this_week', 'this_month', 'last_month']);
    }

    public function test_the_admin_menu_links_to_the_partner_list(): void
    {
        $this->actingAs($this->admin());

        $items = collect(\Botble\Base\Facades\DashboardMenu::getAll())
            ->firstWhere('id', 'cms-plugins-partner')['children'] ?? [];

        $this->assertSame(
            ['cms-plugins-partner-list', 'cms-plugins-partner-networks'],
            collect($items)->pluck('id')->values()->all()
        );
    }

    // --- Aislamiento ------------------------------------------------------------------------

    public function test_the_panel_never_shows_gross_or_platform_figures(): void
    {
        $partner = $this->partnerWith('123456', commission: 10);
        // bruto 1000, la plataforma se queda 450, el partner ve 45.00
        $this->domain('123456', earnings: 1_000_000_000, commissions: 60, commissionsNetwork: 15);

        $response = $this->actingAs($partner, 'member')->get(route('partner.dashboard'));

        $response->assertOk()
            ->assertSee('45.00')        // lo suyo
            ->assertDontSee('1,000.00') // el bruto del reporte
            ->assertDontSee('450.00');  // la parte de la plataforma
    }

    public function test_the_panel_never_shows_creator_data(): void
    {
        $creator = Member::query()->forceCreate([
            'first_name' => 'Zoraida',
            'last_name' => 'Unrepeatable',
            'username' => 'creator_'.uniqid(),
            'email' => 'zoraida-unrepeatable@example.test',
            'password' => 'secret-password',
            'role' => PartnerRoleEnum::CREATOR,
        ]);

        $partner = $this->partnerWith('123456', commission: 10);
        $this->domain('123456', earnings: 100_000_000, commissions: 60, commissionsNetwork: 15, memberId: $creator->getKey());

        $this->actingAs($partner, 'member')
            ->get(route('partner.domains'))
            ->assertOk()
            ->assertDontSee('Zoraida')
            ->assertDontSee('zoraida-unrepeatable@example.test');
    }

    // --- Menú por rol ---------------------------------------------------------------------------

    public function test_the_partner_menu_replaces_the_creator_entries(): void
    {
        $items = $this->menuFor($this->partnerWith('123456'));

        $this->assertContains('cms-partner-dashboard', $items);
        $this->assertContains('cms-partner-accounts', $items);
        $this->assertContains('cms-partner-domains', $items);

        $this->assertNotContains('cms-member-dashboard', $items);
        $this->assertNotContains('cms-member-referrals', $items);
        $this->assertNotContains('cms-member-invoices', $items);
    }

    public function test_the_creator_menu_is_left_untouched(): void
    {
        $creator = Member::query()->forceCreate([
            'first_name' => 'Test',
            'last_name' => 'Creator',
            'username' => 'creator_'.uniqid(),
            'email' => uniqid().'@example.test',
            'password' => 'secret-password',
            'role' => PartnerRoleEnum::CREATOR,
        ]);

        $items = $this->menuFor($creator);

        $this->assertContains('cms-member-dashboard', $items);
        $this->assertContains('cms-member-referrals', $items);
        $this->assertContains('cms-member-invoices', $items);

        foreach ($items as $id) {
            $this->assertStringNotContainsString('cms-partner-', $id);
        }
    }

    /**
     * @return array<int, string>
     */
    protected function menuFor(Member $member): array
    {
        $this->actingAs($member, 'member');

        return collect(\Botble\Base\Facades\DashboardMenu::getAll('member'))->pluck('id')->all();
    }

    // --- Resolución de vistas -----------------------------------------------------------------

    public function test_it_falls_back_to_the_plugin_views_when_the_theme_has_none(): void
    {
        // El tema por defecto en tests no define vistas de partner.
        $this->actingAs($this->partnerWith('123456'), 'member')
            ->get(route('partner.dashboard'))
            ->assertOk()
            ->assertViewIs('plugins/partner::themes.dashboard.index');
    }

    // --- Utilidades -----------------------------------------------------------------------------

    protected function partner(?float $commission = null): Member
    {
        return Member::query()->forceCreate([
            'first_name' => 'Test',
            'last_name' => 'Partner',
            'username' => 'partner_'.uniqid(),
            'email' => uniqid().'@example.test',
            'password' => 'secret-password',
            'role' => PartnerRoleEnum::PARTNER,
            'commission' => $commission,
        ]);
    }

    protected function admin(): \Botble\ACL\Models\User
    {
        $admin = \Botble\ACL\Models\User::query()->forceCreate([
            'first_name' => 'Test',
            'last_name' => 'Admin',
            'username' => 'admin_'.uniqid(),
            'email' => uniqid().'@example.test',
            'password' => 'secret-password',
        ]);
        $admin->forceFill(['super_user' => true])->save();

        return $admin;
    }

    protected function partnerWith(string $networkCode, ?float $commission = null): Member
    {
        $partner = $this->partner($commission);
        $this->network($partner, $networkCode);

        return $partner;
    }

    protected function network(Member $partner, string $code, ?float $commission = null): PartnerNetwork
    {
        return PartnerNetwork::query()->create([
            'member_id' => $partner->getKey(),
            'network_code' => $code,
            'commission' => $commission,
        ]);
    }

    protected function domain(
        string $networkCode,
        int $earnings = 0,
        ?float $commissions = 60,
        ?float $commissionsNetwork = 15,
        int $impressions = 0,
        int $clicks = 0,
        string $url = 'domain.test',
        ?int $memberId = null,
        string $period = 'today',
    ): Domain {
        return Domain::query()->forceCreate([
            'name' => $url,
            'url' => uniqid().'-'.$url,
            'network_code' => $networkCode,
            'commissions' => $commissions,
            'commissions_network' => $commissionsNetwork,
            'member_id' => $memberId,
            'earnings' => [$period => $earnings],
            'impressions' => [$period => $impressions],
            'clicks' => [$period => $clicks],
        ]);
    }
}
