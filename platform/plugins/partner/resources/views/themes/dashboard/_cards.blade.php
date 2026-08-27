<div class="cards">
    @if($visibleMetrics['earning'])
        <div class="card"><div class="label">{{ trans('plugins/partner::partner.dashboard.earning') }}</div><div class="value">{{ number_format($metrics->earning, 2) }}</div></div>
    @endif
    @if($visibleMetrics['impressions'])
        <div class="card"><div class="label">{{ trans('plugins/partner::partner.dashboard.impressions') }}</div><div class="value">{{ number_format($metrics->impressions) }}</div></div>
    @endif
    @if($visibleMetrics['clicks'])
        <div class="card"><div class="label">{{ trans('plugins/partner::partner.dashboard.clicks') }}</div><div class="value">{{ number_format($metrics->clicks) }}</div></div>
    @endif
    @if($visibleMetrics['ctrs'])
        <div class="card"><div class="label">{{ trans('plugins/partner::partner.dashboard.ctr') }}</div><div class="value">{{ number_format($metrics->ctr, 2) }}%</div></div>
    @endif
    @if($visibleMetrics['ecpms'])
        <div class="card"><div class="label">{{ trans('plugins/partner::partner.dashboard.ecpm') }}</div><div class="value">{{ number_format($metrics->ecpm, 2) }}</div></div>
    @endif
</div>
