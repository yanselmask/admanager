<?php

namespace Botble\Admanager\Services;


use Botble\Domain\Models\Domain;
use Google\AdsApi\AdManager\AdManagerSession;
use Google\AdsApi\AdManager\AdManagerSessionBuilder;
use Google\AdsApi\AdManager\Util\v202411\ReportDownloader;
use Google\AdsApi\AdManager\v202411\Column;
use Google\AdsApi\AdManager\v202411\Dimension;
use Google\AdsApi\AdManager\v202411\ExportFormat;
use Google\AdsApi\AdManager\v202411\ReportJob;
use Google\AdsApi\AdManager\v202411\ReportQuery;
use Google\AdsApi\AdManager\v202411\ReportQueryAdUnitView;
use Google\AdsApi\AdManager\v202411\ServiceFactory;
use Google\AdsApi\Common\OAuth2TokenBuilder;

class Admanager {

    protected string $networkCode;

    protected string $networkName;

    protected AdManagerSession $session;

    protected $oAuth2Credential;

    protected $dateCsv;

    protected $dateRangeType;

    protected $column;

    public function __construct()
    {
    }

    public function setNetworkCode($networkCode)
    {
        $this->networkCode = $networkCode;

        $adsapi = storage_path('adsapi_php.ini');
        $contenido = file_get_contents($adsapi);
        $nuevaRuta = 'networkCode = "' . $networkCode  .'"';
        $contenidoModificado = preg_replace(
            '/networkCode\s*=\s*".*?"/',
            $nuevaRuta,
            $contenido
        );

        file_put_contents($adsapi, $contenidoModificado);

        return $this;
    }

    public function setNetworkName($networkName)
    {
        $this->networkName = $networkName;

        $adsapi = storage_path('adsapi_php.ini');
        $contenido = file_get_contents($adsapi);
        $nuevaRuta = 'applicationName = "' . $networkName  .'"';
        $contenidoModificado = preg_replace(
            '/applicationName\s*=\s*".*?"/',
            $nuevaRuta,
            $contenido
        );

        file_put_contents($adsapi, $contenidoModificado);

        return $this;
    }

    public function setSession(AdManagerSession $session)
    {

        (new AdManagerSessionBuilder())
            ->fromFile(storage_path('adsapi_php.ini'))
            ->withOAuth2Credential($this->oAuth2Credential)
            ->build();

        return $this;
    }

    public function setDateCsv($dateCsv)
    {
        $this->dateCsv = $dateCsv;

        return $this;
    }

    public function setDateRangeType($dateRangeType)
    {
        $this->dateRangeType = $dateRangeType;

        return $this;
    }

    public function setColumn($column)
    {
        $this->column = $column;

        return $this;
    }

    public function run()
    {
        $this->oAuth2Credential = (new OAuth2TokenBuilder())
            ->fromFile(storage_path('adsapi_php.ini'))
            ->build();

        $this->session = (new AdManagerSessionBuilder())
            ->fromFile(storage_path('adsapi_php.ini'))
            ->withOAuth2Credential($this->oAuth2Credential)
            ->build();

        self::runReport(
            new ServiceFactory(),
            $this->session,
            dateCsv: $this->dateCsv,
            dateRangeType: $this->dateRangeType,
            column: $this->column
        );

    }


    public static function runReport(
        ServiceFactory $serviceFactory,
        AdManagerSession $session,
        string $dateCsv,
        string $dateRangeType,
        string $column,
    ) {
        $reportService = $serviceFactory->createReportService($session);
        // Create report query.
        $reportQuery = new ReportQuery();
        $reportQuery->setDimensions(
            [
                Dimension::SITE_NAME
            ]
        );
        $reportQuery->setColumns(
            [
                Column::AD_EXCHANGE_LINE_ITEM_LEVEL_IMPRESSIONS,
                Column::AD_EXCHANGE_LINE_ITEM_LEVEL_CLICKS,
                Column::AD_EXCHANGE_LINE_ITEM_LEVEL_CTR,
                Column::AD_EXCHANGE_LINE_ITEM_LEVEL_REVENUE,
                Column::AD_EXCHANGE_LINE_ITEM_LEVEL_AVERAGE_ECPM,
                Column::AD_EXCHANGE_LINE_ITEM_LEVEL_PERCENT_IMPRESSIONS
            ]
        );
        // Set the ad unit view to hierarchical.
        $reportQuery->setAdUnitView(ReportQueryAdUnitView::HIERARCHICAL);
        // Set the start and end dates or choose a dynamic date range type.
        $dateEvaluated = self::evaluateDate($dateRangeType);


        if(is_array($dateEvaluated))
        {
            $reportQuery->setStartDate($dateEvaluated[0]);
            $reportQuery->setEndDate($dateEvaluated[1]);
        }else{
            $reportQuery->setDateRangeType($dateRangeType);
        }


        // Create report job and start it.
        $reportJob = new ReportJob();
        $reportJob->setReportQuery($reportQuery);
        $reportJob = $reportService->runReportJob($reportJob);
        // Create report downloader to poll report's status and download when
        // ready.
        $reportDownloader = new ReportDownloader(
            $reportService,
            $reportJob->getId()
        );
        if ($reportDownloader->waitForReportToFinish()) {
            // 🔹 Crear archivo temporal comprimido
            $gzFile = sprintf(
                '%s.csv.gz',
                tempnam(sys_get_temp_dir(), 'inventory-report-')
            );

            $reportDownloader->downloadReport(ExportFormat::CSV_DUMP, $gzFile);

            $csvFile = storage_path($dateCsv . '.csv');

            $fp = gzopen($gzFile, 'rb');
            $csvFp = fopen($csvFile, 'wb');

            while (!gzeof($fp)) {
                fwrite($csvFp, gzread($fp, 4096));
            }

            gzclose($fp);
            fclose($csvFp);

            unlink($gzFile);

            self::updateEarning($csvFile, $column);
        }
    }

    public static function main(
        $dateCsv,
        $dateRangeType,
        $column
    )
    {
        // Generate a refreshable OAuth2 credential for authentication.
        $oAuth2Credential = (new OAuth2TokenBuilder())
            ->fromFile(storage_path('adsapi_php.ini'))
            ->build();

        // Construct an API session configured from an `adsapi_php.ini` file
        // and the OAuth2 credentials above.
        $session = (new AdManagerSessionBuilder())
            ->fromFile(storage_path('adsapi_php.ini'))
            ->withOAuth2Credential($oAuth2Credential)
            ->build();

        self::runReport(
            new ServiceFactory(),
            $session,
            dateCsv: $dateCsv,
            dateRangeType: $dateRangeType,
            column: $column
        );
    }

    public static function  updateEarning($csvFile, $column)
    {
        if (!file_exists($csvFile)) {
            throw new \Exception("El archivo CSV no existe: $csvFile");
        }

        if (($handle = fopen($csvFile, "r")) !== FALSE) {
            $headers = fgetcsv($handle, 1000, ",");

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $domainName = trim($data[0]);
                $valueImpressions = floatval($data[1]);
                $valueClicks = floatval($data[2]);
                $valueCtrs = floatval($data[3]);
                $valueEarnings = floatval($data[4]);
                $valueEcpms = floatval($data[5]);

                if (is_plugin_active('domain')) {
                    $domain = Domain::where('url', $domainName)->first();
                    if ($domain) {
                        $impressions = $domain->impressions ?? [];
                        $clicks = $domain->clicks ?? [];
                        $ctrs = $domain->ctrs ?? [];
                        $earnings = $domain->earnings ?? [];
                        $ecpms = $domain->ecpms ?? [];

                        $impressions[$column] = $valueImpressions;
                        $clicks[$column] = $valueClicks;
                        $ctrs[$column] = $valueCtrs;
                        $earnings[$column] = $valueEarnings;
                        $ecpms[$column] = $valueEcpms;

                        $domain->impressions = $impressions;
                        $domain->clicks = $clicks;
                        $domain->ctrs = $ctrs;
                        $domain->earnings = $earnings;
                        $domain->ecpms = $ecpms;
                        $domain->save();
                    }
                }
            }

            fclose($handle);
        }
    }

    protected static function evaluateDate($dateRangeType)
    {
        return match ($dateRangeType) {
            'THIS_WEEK' => [now()->startOfWeek(setting('week_start')), now()->today()],
            'THIS_MONTH' => [now()->startOfMonth(), now()->today()],
            'LAST_2_MONTHS' => [now()->subMonths(2)->startOfMonth(), now()->today()],
            'LAST_4_MONTHS' => [now()->subMonths(4)->startOfMonth(), now()->today()],
            'LAST_5_MONTHS' => [now()->subMonths(5)->startOfMonth(), now()->today()],
            'LAST_6_MONTHS' => [now()->subMonths(6)->startOfMonth(), now()->today()],
            'LAST_7_MONTHS' => [now()->subMonths(7)->startOfMonth(), now()->today()],
            'LAST_8_MONTHS' => [now()->subMonths(8)->startOfMonth(), now()->today()],
            'LAST_9_MONTHS' => [now()->subMonths(9)->startOfMonth(), now()->today()],
            'LAST_10_MONTHS' => [now()->subMonths(10)->startOfMonth(), now()->today()],
            'LAST_11_MONTHS' => [now()->subMonths(11)->startOfMonth(), now()->today()],
            default => $dateRangeType
        };
    }


    public function getNetworksCode()
    {
        $networks = json_decode(setting('admanager_networks'), true);

        $formatted = collect($networks)
            ->flatten(1)
            ->map(function ($network) {
                if($network['key'] == 'code')
                {
                    return $network['value'];
                }
            })
            ->filter()
            ->toArray();

        return array_values($formatted);
    }

    public function getNetworksCodeAndName()
    {
        $networks = json_decode(setting('admanager_networks'), true);

        $formatted = collect($networks)
            ->mapWithKeys(function ($items) {
                $pair = [];
                foreach ($items as $item) {
                    if ($item['key'] == 'code') {
                        $pair['code'] = $item['value'];
                    }
                    if ($item['key'] == 'name') {
                        $pair['name'] = $item['value'];
                    }
                }
                return isset($pair['code'], $pair['name']) ? [$pair['code'] => $pair['name']] : [];
            })
            ->toArray();

        return $formatted;
    }

}
