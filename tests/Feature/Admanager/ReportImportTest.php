<?php

namespace Tests\Feature\Admanager;

use Botble\Admanager\Services\Admanager;
use Botble\Domain\Models\Domain;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReportImportTest extends TestCase
{
    use DatabaseTransactions;

    public function test_an_unknown_site_is_registered_in_the_report_network(): void
    {
        Admanager::updateEarning($this->csv([
            ['nuevo-sitio.test', 1500, 30, 0.02, 2500000, 1666666],
        ]), 'today', '23329685194');

        $domain = Domain::query()->where('url', 'nuevo-sitio.test')->sole();

        $this->assertSame('23329685194', $domain->network_code);
        $this->assertNull($domain->member_id);
        $this->assertEquals(1500, $domain->impressions['today']);
        $this->assertEquals(2500000, $domain->earnings['today']);
    }

    public function test_a_known_site_is_updated_without_changing_its_owner_or_network(): void
    {
        $domain = Domain::query()->forceCreate([
            'name' => 'existente.test',
            'url' => 'existente.test',
            'network_code' => '22970178380',
            'member_id' => 99,
            'earnings' => ['yesterday' => 100],
        ]);

        Admanager::updateEarning($this->csv([
            ['existente.test', 200, 4, 0.02, 900000, 4500000],
        ]), 'today', '23329685194');

        $domain->refresh();

        $this->assertSame('22970178380', $domain->network_code);
        $this->assertSame(99, (int) $domain->member_id);
        $this->assertEquals(['yesterday' => 100, 'today' => 900000], $domain->earnings);
        $this->assertSame(1, Domain::query()->where('url', 'existente.test')->count());
    }

    public function test_without_a_network_unknown_sites_are_still_ignored(): void
    {
        Admanager::updateEarning($this->csv([
            ['sin-red.test', 10, 0, 0, 1000, 100000],
        ]), 'today');

        $this->assertFalse(Domain::query()->where('url', 'sin-red.test')->exists());
    }

    public function test_a_site_missing_from_the_report_drops_to_zero_for_that_period(): void
    {
        $stale = Domain::query()->forceCreate([
            'name' => 'sin-trafico.test',
            'url' => 'sin-trafico.test',
            'network_code' => '23089538066',
            'earnings' => ['this_month' => 5147823808, 'last_month' => 5147823808],
            'impressions' => ['this_month' => 893423, 'last_month' => 893423],
        ]);
        $otherNetwork = Domain::query()->forceCreate([
            'name' => 'otra-red.test',
            'url' => 'otra-red.test',
            'network_code' => '22970178380',
            'earnings' => ['this_month' => 700],
        ]);

        Admanager::updateEarning($this->csv([]), 'this_month', '23089538066');

        $stale->refresh();

        $this->assertEquals(0, $stale->earnings['this_month']);
        $this->assertEquals(0, $stale->impressions['this_month']);
        $this->assertEquals(5147823808, $stale->earnings['last_month']);
        $this->assertEquals(700, $otherNetwork->fresh()->earnings['this_month']);
    }

    public function test_repeated_runs_do_not_duplicate_a_registered_site(): void
    {
        foreach (['today', 'yesterday'] as $column) {
            Admanager::updateEarning($this->csv([
                ['repetido.test', 10, 0, 0, 1000, 100000],
            ]), $column, '23329685194');
        }

        $this->assertSame(1, Domain::query()->where('url', 'repetido.test')->count());
    }

    /**
     * @param  array<int, array<int, string|int|float>>  $rows
     */
    protected function csv(array $rows): string
    {
        $path = tempnam(sys_get_temp_dir(), 'report-').'.csv';
        $handle = fopen($path, 'w');

        fputcsv($handle, [
            'Dimension.SITE_NAME',
            'Column.AD_EXCHANGE_LINE_ITEM_LEVEL_IMPRESSIONS',
            'Column.AD_EXCHANGE_LINE_ITEM_LEVEL_CLICKS',
            'Column.AD_EXCHANGE_LINE_ITEM_LEVEL_CTR',
            'Column.AD_EXCHANGE_LINE_ITEM_LEVEL_REVENUE',
            'Column.AD_EXCHANGE_LINE_ITEM_LEVEL_AVERAGE_ECPM',
        ]);

        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return $path;
    }
}
