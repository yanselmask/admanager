@extends('theme.moreno::views.partner.dashboard._shell')

@section('panel')
    @if($networks->isEmpty())
        <section class="moreno-dashboard-welcome mb-4">
            <div>
                <span class="moreno-dashboard-kicker">Panel de partner</span>
                <h1>{{ trans('plugins/partner::partner.dashboard.no_networks') }}</h1>
                <p>En cuanto se te asocie una cuenta de Ad Manager, verás aquí sus ingresos completos con tu porcentaje ya aplicado.</p>
            </div>
            <div class="moreno-dashboard-welcome-mark" aria-hidden="true"><span class="fas fa-briefcase"></span></div>
        </section>
    @endif

    @include('theme.moreno::views.partner.dashboard._cards')

    @if($networks->isNotEmpty() && ($visibleMetrics['earning'] ?? true))
        <div class="card border-0 mb-4" style="background: var(--ms-surface, #191d24);">
            <div class="card-body p-4">
                <h5 class="mb-3">Evolución de ganancias</h5>
                <div id="partner-earnings-chart" style="height: 320px;"></div>
            </div>
        </div>

        @push('scripts')
            <script>
                (function () {
                    var el = document.getElementById('partner-earnings-chart');

                    if (!el || typeof echarts === 'undefined') {
                        return;
                    }

                    var chart = echarts.init(el);

                    chart.setOption({
                        tooltip: { trigger: 'axis' },
                        grid: { left: 56, right: 20, top: 24, bottom: 40 },
                        xAxis: {
                            type: 'category',
                            data: @json(array_values(array_map(fn ($k) => trans('plugins/partner::partner.periods.' . $k), array_keys($series)))),
                            axisLabel: { color: '#8b95a3', rotate: 30 }
                        },
                        yAxis: { type: 'value', axisLabel: { color: '#8b95a3' }, splitLine: { lineStyle: { color: '#232830' } } },
                        series: [{
                            name: @json(trans('plugins/partner::partner.dashboard.earning')),
                            type: 'bar',
                            data: @json(array_values($series)),
                            itemStyle: { color: '#2879d2', borderRadius: [4, 4, 0, 0] }
                        }]
                    });

                    window.addEventListener('resize', function () { chart.resize(); });
                })();
            </script>
        @endpush
    @endif
@endsection
