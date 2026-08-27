<?php

namespace Botble\Partner\Data;

class PartnerMetrics
{
    public function __construct(
        public readonly float $earning = 0.0,
        public readonly float $impressions = 0.0,
        public readonly float $clicks = 0.0,
        public readonly float $ctr = 0.0,
        public readonly float $ecpm = 0.0,
    ) {}

    public static function zero(): self
    {
        return new self;
    }

    /**
     * Construye las métricas a partir de los totales agregados. El CTR y el eCPM se
     * derivan aquí, sobre las sumas, y nunca promediando los valores por dominio:
     * el promedio por dominio es incorrecto cuando los volúmenes son dispares.
     */
    public static function fromTotals(float $earning, float $impressions, float $clicks): self
    {
        return new self(
            earning: $earning,
            impressions: $impressions,
            clicks: $clicks,
            ctr: $impressions > 0 ? ($clicks / $impressions) * 100 : 0.0,
            ecpm: $impressions > 0 ? ($earning / $impressions) * 1000 : 0.0,
        );
    }

    /**
     * @return array{earning: float, impressions: float, clicks: float, ctr: float, ecpm: float}
     */
    public function toArray(): array
    {
        return [
            'earning' => $this->earning,
            'impressions' => $this->impressions,
            'clicks' => $this->clicks,
            'ctr' => $this->ctr,
            'ecpm' => $this->ecpm,
        ];
    }
}
