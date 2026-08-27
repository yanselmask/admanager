@php
    $palette = [
        'earning'     => ['icon' => 'fas fa-dollar-sign',   'label' => 'Ganancias',   'gradient' => 'linear-gradient(135deg, #12498D 0%, #2879D2 100%)', 'shadow' => 'rgba(42,122,228,0.25)',  'value' => '$' . number_format($metrics->earning, 2)],
        'impressions' => ['icon' => 'fas fa-chart-bar',      'label' => 'Impresiones', 'gradient' => 'linear-gradient(135deg, #10375F 0%, #2869A7 100%)', 'shadow' => 'rgba(40,105,167,0.25)',  'value' => number_format($metrics->impressions)],
        'clicks'      => ['icon' => 'fas fa-mouse-pointer',  'label' => 'Clicks',      'gradient' => 'linear-gradient(135deg, #145A5D 0%, #2C9388 100%)', 'shadow' => 'rgba(44,147,136,0.22)',  'value' => number_format($metrics->clicks)],
        'ctrs'        => ['icon' => 'fas fa-chart-line',     'label' => 'CTR',         'gradient' => 'linear-gradient(135deg, #765C26 0%, #B38731 100%)', 'shadow' => 'rgba(179,135,49,0.2)',   'value' => number_format($metrics->ctr, 2) . '%'],
        'ecpms'       => ['icon' => 'fas fa-money-bill',     'label' => 'eCPM',        'gradient' => 'linear-gradient(135deg, #1B5680 0%, #2C8AB7 100%)', 'shadow' => 'rgba(44,138,183,0.22)',  'value' => '$' . number_format($metrics->ecpm, 2)],
    ];
@endphp

<div class="row g-3 mb-4">
    @foreach($palette as $key => $stat)
        @continue(! ($visibleMetrics[$key] ?? true))
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100 border-0 overflow-hidden moreno-legacy-stat-card"
                 style="background: {{ $stat['gradient'] }}; box-shadow: 0 6px 24px {{ $stat['shadow'] }};">
                <div class="card-body p-4 position-relative">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="moreno-legacy-stat-icon"><span class="{{ $stat['icon'] }}" aria-hidden="true"></span></div>
                        <span class="moreno-legacy-stat-label">{{ $stat['label'] }}</span>
                    </div>
                    <h2 class="moreno-legacy-stat-value">{{ $stat['value'] }}</h2>
                    <div class="position-absolute moreno-legacy-stat-mark" aria-hidden="true"><span class="{{ $stat['icon'] }}"></span></div>
                </div>
            </div>
        </div>
    @endforeach
</div>
