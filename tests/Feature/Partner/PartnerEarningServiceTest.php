<?php

namespace Tests\Feature\Partner;

use Botble\Domain\Models\Domain;
use Botble\Member\Models\Member;
use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Partner\Models\PartnerNetwork;
use Botble\Partner\Services\PartnerEarningService;
use Botble\Setting\Facades\Setting;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PartnerEarningServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected PartnerEarningService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(PartnerEarningService::class);
        $this->useBase(PartnerEarningService::BASE_PLATFORM_NET);
        Setting::set('percentage_default', 12)->save();
    }

    protected function tearDown(): void
    {
        Setting::forget('partner_earning_base');
        Setting::forget('percentage_default');
        Setting::forget('partner_percentage_default');
        Carbon::setTestNow();

        parent::tearDown();
    }

    // --- Base de cálculo de la ganancia -----------------------------------------------

    public function test_the_platform_net_base_applies_the_commission_over_what_the_platform_receives(): void
    {
        $partner = $this->partnerWithNetwork('100001', partnerCommission: 10);

        // 100 unidades, la plataforma se queda 60 - 15 = 45, el partner el 10% de eso.
        $this->domain('100001', earnings: 100_000_000, commissions: 60, commissionsNetwork: 15);

        $this->assertEqualsWithDelta(4.50, $this->service->forPartner($partner, 'today')->earning, 0.0001);
    }

    public function test_the_gross_base_applies_the_commission_over_the_raw_revenue(): void
    {
        $this->useBase(PartnerEarningService::BASE_GROSS);

        $partner = $this->partnerWithNetwork('100002', partnerCommission: 10);
        $this->domain('100002', earnings: 100_000_000, commissions: 60, commissionsNetwork: 15);

        $this->assertEqualsWithDelta(10.00, $this->service->forPartner($partner, 'today')->earning, 0.0001);
    }

    public function test_a_domain_without_commissions_falls_back_to_the_global_percentage(): void
    {
        Setting::set('percentage_default', 20)->save();

        $partner = $this->partnerWithNetwork('100003', partnerCommission: 10);
        $this->domain('100003', earnings: 100_000_000, commissions: null, commissionsNetwork: null);

        // base = 100 * (20 - 0) / 100 = 20 ; partner = 2.00
        $this->assertEqualsWithDelta(2.00, $this->service->forPartner($partner, 'today')->earning, 0.0001);
    }

    public function test_a_negative_base_is_truncated_to_zero_without_subtracting_from_other_domains(): void
    {
        $partner = $this->partnerWithNetwork('100004', partnerCommission: 10);

        // commissions_network > commissions -> base negativa, se trunca a 0
        $this->domain('100004', earnings: 100_000_000, commissions: 10, commissionsNetwork: 40);
        // dominio sano en la misma network: base = 100 * 0.45 = 45 ; partner = 4.50
        $this->domain('100004', earnings: 100_000_000, commissions: 60, commissionsNetwork: 15, url: 'healthy.test');

        $this->assertEqualsWithDelta(4.50, $this->service->forPartner($partner, 'today')->earning, 0.0001);
    }

    public function test_a_period_with_no_data_contributes_zero(): void
    {
        $partner = $this->partnerWithNetwork('100005', partnerCommission: 10);
        $this->domain('100005', earnings: 100_000_000, commissions: 60, commissionsNetwork: 15);

        $metrics = $this->service->forPartner($partner, 'this_year');

        $this->assertSame(0.0, $metrics->earning);
        $this->assertSame(0.0, $metrics->impressions);
    }

    public function test_the_commission_of_each_network_is_applied_before_summing(): void
    {
        $this->useBase(PartnerEarningService::BASE_GROSS);

        $partner = $this->partner(commission: null);
        $this->network($partner, '100006', commission: 10);
        $this->network($partner, '100007', commission: 15);

        $this->domain('100006', earnings: 100_000_000);
        $this->domain('100007', earnings: 200_000_000);

        // 100 * 0.10 + 200 * 0.15 = 40
        $this->assertEqualsWithDelta(40.00, $this->service->forPartner($partner, 'today')->earning, 0.0001);
    }

    // --- Métricas de volumen y derivadas ----------------------------------------------

    public function test_impressions_and_clicks_are_summed_raw(): void
    {
        $partner = $this->partnerWithNetwork('100008', partnerCommission: 10);
        $this->domain('100008', impressions: 4000, clicks: 100);
        $this->domain('100008', impressions: 6000, clicks: 150, url: 'second.test');

        $metrics = $this->service->forPartner($partner, 'today');

        $this->assertSame(10000.0, $metrics->impressions);
        $this->assertSame(250.0, $metrics->clicks);
    }

    public function test_the_ctr_is_recalculated_over_the_totals(): void
    {
        $partner = $this->partnerWithNetwork('100009', partnerCommission: 10);
        $this->domain('100009', impressions: 10000, clicks: 250);

        $this->assertEqualsWithDelta(2.50, $this->service->forPartner($partner, 'today')->ctr, 0.0001);
    }

    public function test_the_ecpm_is_derived_from_the_partner_earning(): void
    {
        $partner = $this->partnerWithNetwork('100010', partnerCommission: 10);
        $this->domain('100010', earnings: 100_000_000, commissions: 60, commissionsNetwork: 15, impressions: 10000);

        // ganancia 4.50 sobre 10.000 impresiones -> 0.45 por mil
        $this->assertEqualsWithDelta(0.45, $this->service->forPartner($partner, 'today')->ecpm, 0.0001);
    }

    public function test_zero_impressions_do_not_divide_by_zero(): void
    {
        $partner = $this->partnerWithNetwork('100011', partnerCommission: 10);
        $this->domain('100011', earnings: 100_000_000, commissions: 60, commissionsNetwork: 15, impressions: 0, clicks: 0);

        $metrics = $this->service->forPartner($partner, 'today');

        $this->assertSame(0.0, $metrics->ctr);
        $this->assertSame(0.0, $metrics->ecpm);
    }

    // --- Periodos ----------------------------------------------------------------------

    public function test_an_explicit_period_is_honoured(): void
    {
        $partner = $this->partnerWithNetwork('100012', partnerCommission: 10);
        $this->domain('100012', earnings: 100_000_000, commissions: 60, commissionsNetwork: 15, period: 'this_month');

        $this->assertEqualsWithDelta(4.50, $this->service->forPartner($partner, 'this_month')->earning, 0.0001);
        $this->assertSame(0.0, $this->service->forPartner($partner, 'today')->earning);
    }

    public function test_an_omitted_or_unknown_period_falls_back_to_today(): void
    {
        $this->assertSame('today', $this->service->resolvePeriod(null));
        $this->assertSame('today', $this->service->resolvePeriod('not_a_period'));
        $this->assertSame('this_month', $this->service->resolvePeriod('this_month'));
    }

    // --- Alcance de los datos ----------------------------------------------------------

    public function test_only_domains_of_the_assigned_networks_are_counted(): void
    {
        $this->useBase(PartnerEarningService::BASE_GROSS);

        $partner = $this->partnerWithNetwork('100013', partnerCommission: 10);
        $this->domain('100013', earnings: 100_000_000);
        $this->domain('999999', earnings: 900_000_000, url: 'foreign.test');

        $this->assertEqualsWithDelta(10.00, $this->service->forPartner($partner, 'today')->earning, 0.0001);
    }

    public function test_a_domain_without_a_creator_is_still_counted(): void
    {
        $this->useBase(PartnerEarningService::BASE_GROSS);

        $partner = $this->partnerWithNetwork('100014', partnerCommission: 10);
        $this->domain('100014', earnings: 100_000_000, memberId: null);

        $this->assertEqualsWithDelta(10.00, $this->service->forPartner($partner, 'today')->earning, 0.0001);
    }

    public function test_partners_are_isolated_from_each_other(): void
    {
        $this->useBase(PartnerEarningService::BASE_GROSS);

        $a = $this->partnerWithNetwork('100015', partnerCommission: 10);
        $b = $this->partnerWithNetwork('100016', partnerCommission: 10);

        $this->domain('100015', earnings: 100_000_000);
        $this->domain('100016', earnings: 500_000_000, url: 'b.test');

        $this->assertEqualsWithDelta(10.00, $this->service->forPartner($a, 'today')->earning, 0.0001);
        $this->assertEqualsWithDelta(50.00, $this->service->forPartner($b, 'today')->earning, 0.0001);
    }

    public function test_a_partner_without_networks_gets_zeroed_metrics(): void
    {
        $partner = $this->partner();

        $metrics = $this->service->forPartner($partner, 'today');

        $this->assertSame(0.0, $metrics->earning);
        $this->assertSame(0.0, $metrics->impressions);
        $this->assertTrue($this->service->byNetwork($partner, 'today')->isEmpty());
    }

    // --- Desglose por network -----------------------------------------------------------

    public function test_the_breakdown_sums_up_to_the_total(): void
    {
        $this->useBase(PartnerEarningService::BASE_GROSS);

        $partner = $this->partner(commission: null);
        $this->network($partner, '100017', commission: 10);
        $this->network($partner, '100018', commission: 15);

        $this->domain('100017', earnings: 100_000_000);
        $this->domain('100018', earnings: 200_000_000, url: 'second.test');

        $total = $this->service->forPartner($partner, 'today')->earning;
        $breakdown = $this->service->byNetwork($partner, 'today');

        $this->assertEqualsWithDelta(
            $total,
            $breakdown->sum(fn (array $row) => $row['metrics']->earning),
            0.0001
        );
        $this->assertEqualsWithDelta(10.00, $breakdown['100017']['metrics']->earning, 0.0001);
        $this->assertEqualsWithDelta(30.00, $breakdown['100018']['metrics']->earning, 0.0001);
    }

    public function test_a_network_without_domains_appears_with_zeroed_metrics(): void
    {
        $partner = $this->partnerWithNetwork('100019', partnerCommission: 10);

        $row = $this->service->byNetwork($partner, 'today')['100019'];

        $this->assertSame(0, $row['domains_count']);
        $this->assertSame(0.0, $row['metrics']->earning);
        $this->assertSame(0.0, $row['metrics']->ctr);
    }

    // --- Utilidades ---------------------------------------------------------------------

    // --- Traspaso de una network a partir de una fecha --------------------------------

    public function test_a_handover_splits_the_periods_between_the_old_and_the_new_owner(): void
    {
        Carbon::setTestNow('2026-09-26 10:00:00');

        $previous = $this->partnerWithNetwork('300001');
        $current = $this->partner();
        $this->network($current, '300001', startsAt: '2026-09-01');
        $this->domainWithPeriods('300001', [
            'today' => 10,
            'yesterday' => 20,
            'this_month' => 300,
            'last_month' => 400,
            'last_3_months' => 900,
            'this_year' => 5000,
        ]);

        $impressions = fn (Member $partner, string $period) => $this->service->forPartner($partner, $period)->impressions;

        $this->assertEquals(10, $impressions($current, 'today'));
        $this->assertEquals(20, $impressions($current, 'yesterday'));
        $this->assertEquals(300, $impressions($current, 'this_month'));
        $this->assertEquals(0, $impressions($current, 'last_month'));
        $this->assertEquals(0, $impressions($current, 'this_year'));

        $this->assertEquals(0, $impressions($previous, 'today'));
        $this->assertEquals(0, $impressions($previous, 'this_month'));
        $this->assertEquals(400, $impressions($previous, 'last_month'));
        $this->assertEquals(900, $impressions($previous, 'last_3_months'));
        $this->assertEquals(0, $impressions($previous, 'this_year'));
    }

    public function test_a_period_that_crosses_the_handover_date_counts_for_nobody(): void
    {
        Carbon::setTestNow('2026-09-26 10:00:00');

        $previous = $this->partnerWithNetwork('300002');
        $current = $this->partner();
        $this->network($current, '300002', startsAt: '2026-09-15');
        $this->domainWithPeriods('300002', ['today' => 10, 'this_month' => 300]);

        $this->assertEquals(10, $this->service->forPartner($current, 'today')->impressions);
        $this->assertEquals(0, $this->service->forPartner($current, 'this_month')->impressions);
        $this->assertEquals(0, $this->service->forPartner($previous, 'this_month')->impressions);
    }

    public function test_a_general_assignment_owns_every_period(): void
    {
        Carbon::setTestNow('2026-09-26 10:00:00');

        $partner = $this->partnerWithNetwork('300003');
        $this->domainWithPeriods('300003', ['today' => 10, 'last_3_months' => 900, 'this_year' => 5000]);

        $this->assertEquals(10, $this->service->forPartner($partner, 'today')->impressions);
        $this->assertEquals(900, $this->service->forPartner($partner, 'last_3_months')->impressions);
        $this->assertEquals(5000, $this->service->forPartner($partner, 'this_year')->impressions);
    }

    public function test_an_assignment_starting_in_the_future_owns_nothing_yet(): void
    {
        Carbon::setTestNow('2026-09-26 10:00:00');

        $previous = $this->partnerWithNetwork('300004');
        $upcoming = $this->partner();
        $this->network($upcoming, '300004', startsAt: '2026-10-01');
        $this->domainWithPeriods('300004', ['today' => 10, 'this_month' => 300]);

        $this->assertEquals(0, $this->service->forPartner($upcoming, 'today')->impressions);
        $this->assertEquals(10, $this->service->forPartner($previous, 'today')->impressions);
        $this->assertEquals(300, $this->service->forPartner($previous, 'this_month')->impressions);
    }

    protected function useBase(string $base): void
    {
        Setting::set('partner_earning_base', $base)->save();
    }

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

    protected function partnerWithNetwork(string $networkCode, ?float $partnerCommission = null): Member
    {
        $partner = $this->partner($partnerCommission);
        $this->network($partner, $networkCode);

        return $partner;
    }

    protected function network(Member $partner, string $networkCode, ?float $commission = null, ?string $startsAt = null): PartnerNetwork
    {
        return PartnerNetwork::query()->create([
            'member_id' => $partner->getKey(),
            'network_code' => $networkCode,
            'commission' => $commission,
            'starts_at' => $startsAt,
        ]);
    }

    /**
     * @param  array<string, int>  $impressions
     */
    protected function domainWithPeriods(string $networkCode, array $impressions): Domain
    {
        return Domain::query()->forceCreate([
            'name' => 'periods.test',
            'url' => uniqid().'-periods.test',
            'network_code' => $networkCode,
            'impressions' => $impressions,
            'earnings' => [],
            'clicks' => [],
        ]);
    }

    protected function domain(
        string $networkCode,
        int $earnings = 0,
        ?float $commissions = null,
        ?float $commissionsNetwork = null,
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
