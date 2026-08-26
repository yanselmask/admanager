@extends(Theme::getThemeNamespace('views.member.dashboard') . '.layouts.master')

@section('content')
    {!! apply_filters(MEMBER_TOP_STATISTIC_FILTER, null) !!}

    @if($user->domains->count())
        @php
            $hour = (int) now()->format('H');
            $greeting = $hour < 12 ? 'Buenos días' : ($hour < 18 ? 'Buenas tardes' : 'Buenas noches');
            $periodLabels = [
                'today'      => 'Hoy',
                'yesterday'  => 'Ayer',
                'this_week'  => 'Esta semana',
                'last_week'  => 'Semana pasada',
                'this_month' => 'Este mes',
                'last_month' => 'Mes pasado',
            ];
            $currentPeriod = request()->query('period', 'today');
            $periodLabel   = $periodLabels[$currentPeriod] ?? 'Hoy';

            $popoverParts = array_filter([
                $cards['commissions_network_formatted'],
                $cards['commissions_platform_formatted'],
            ]);
            $earningsPopover = !empty($popoverParts) ? implode(' · ', $popoverParts) : null;

            $metrics = [
                [
                    'label'   => 'Ganancias',
                    'value'   => '$' . number_format((float) $cards['earning'], 2),
                    'icon'    => 'fas fa-dollar-sign',
                    'color'   => '#2ecc71',
                    'popover' => $earningsPopover,
                ],
                [
                    'label'   => 'Impresiones',
                    'value'   => number_format((float) $cards['impressions'], 0),
                    'icon'    => 'fas fa-eye',
                    'color'   => '#3498db',
                    'popover' => null,
                ],
                [
                    'label'   => 'eCPM',
                    'value'   => '$' . $cards['ecpms'],
                    'icon'    => 'fas fa-money-bill-wave',
                    'color'   => '#9b59b6',
                    'popover' => null,
                ],
                [
                    'label'   => 'Clicks',
                    'value'   => number_format((float) $cards['clicks'], 0),
                    'icon'    => 'fas fa-mouse-pointer',
                    'color'   => '#e67e22',
                    'popover' => null,
                ],
                [
                    'label'   => 'CTR',
                    'value'   => $cards['ctrs'] ?: '0.00%',
                    'icon'    => 'fas fa-chart-line',
                    'color'   => '#1abc9c',
                    'popover' => null,
                ],
                [
                    'label'   => 'CPC',
                    'value'   => '$' . ($cards['cpc'] ?: '0.00'),
                    'icon'    => 'fas fa-hand-holding-usd',
                    'color'   => '#e74c3c',
                    'popover' => null,
                ],
            ];
        @endphp

        {{-- Top bar: greeting + period selector --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div>
                <h5 class="mb-0 fw-bold" style="color:var(--falcon-body-color);">
                    {{ $greeting }}, {{ $user->name }}
                </h5>
                <small style="color:var(--falcon-600);">Período: <strong>{{ $periodLabel }}</strong></small>
            </div>
            <div class="d-flex flex-wrap gap-1">
                @foreach($periodLabels as $key => $lbl)
                    <button
                        type="button"
                        onclick="updateDomainBtn('{{ $key }}', 'period')"
                        class="btn btn-sm {{ $currentPeriod === $key ? 'btn-dark' : 'btn-outline-secondary' }}"
                        style="font-size:.72rem; border-radius:4px; padding:.22rem .65rem;"
                    >{{ $lbl }}</button>
                @endforeach
            </div>
        </div>

        {{-- Domain selector row --}}
        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid var(--falcon-border-color);">
            <label class="mb-0 fw-semibold" style="font-size:.78rem; color:var(--falcon-600); white-space:nowrap;">
                <i class="fas fa-globe me-1"></i> Dominio
            </label>
            <select id="domain" onchange="updateDomain(event)" class="form-select form-select-sm" style="max-width:280px; border-radius:6px; font-size:.82rem;">
                @foreach($user->domains as $dname)
                    <option @selected(request()->query('domain') == $dname->url) value="{{ $dname->url }}">
                        {{ $dname->name }}
                    </option>
                @endforeach
                <option value="any" @selected(request()->query('domain') == 'any')>Todos los dominios</option>
            </select>
        </div>

        {{-- Earnings hero row --}}
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-5">
                <div class="p-4 h-100 d-flex flex-column justify-content-between"
                     style="background:var(--falcon-card-bg); border:1px solid var(--falcon-border-color); border-left:4px solid #2ecc71; border-radius:8px;">
                    <div>
                        <p class="mb-1 text-uppercase fw-semibold" style="font-size:.65rem; letter-spacing:1px; color:var(--falcon-600);">
                            <i class="fas fa-dollar-sign me-1"></i> Ganancias del período
                        </p>
                        <h1 class="fw-bold mb-0" style="font-size:3rem; letter-spacing:-1px; color:#2ecc71;">
                            ${{ number_format((float) $cards['earning'], 2) }}
                        </h1>
                    </div>
                    @if($earningsPopover)
                        <p class="mb-0 mt-3" style="font-size:.78rem; color:var(--falcon-600);">
                            <i class="fas fa-info-circle me-1"></i> {{ $earningsPopover }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="col-12 col-md-7">
                <div class="h-100"
                     style="background:var(--falcon-card-bg); border:1px solid var(--falcon-border-color); border-radius:8px;">
                    <table class="table table-borderless mb-0 h-100" style="font-size:.88rem;">
                        <tbody>
                            @foreach(array_slice($metrics, 1) as $m)
                                <tr style="border-bottom: 1px solid var(--falcon-border-color);">
                                    <td class="py-2 ps-4" style="color:var(--falcon-600); width:44%;">
                                        <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:{{ $m['color'] }}; margin-right:8px;"></span>
                                        {{ $m['label'] }}
                                    </td>
                                    <td class="py-2 pe-4 text-end fw-semibold" style="color:var(--falcon-body-color);">
                                        {{ $m['value'] }}
                                        @if($m['popover'])
                                            <i class="fas fa-info-circle ms-1"
                                               style="font-size:.75rem; color:var(--falcon-600); cursor:pointer;"
                                               data-bs-toggle="popover"
                                               data-bs-placement="top"
                                               data-bs-content="{{ $m['popover'] }}"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Compact KPI strip --}}
        <div class="row g-2">
            @foreach($metrics as $m)
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="text-center py-3 px-2"
                         style="background:var(--falcon-card-bg); border:1px solid var(--falcon-border-color); border-top:3px solid {{ $m['color'] }}; border-radius:8px;">
                        <i class="{{ $m['icon'] }} mb-2" style="font-size:1rem; color:{{ $m['color'] }};"></i>
                        <p class="mb-0 fw-bold" style="font-size:.95rem; color:var(--falcon-body-color);">
                            {{ $m['value'] }}
                        </p>
                        <p class="mb-0" style="font-size:.62rem; text-transform:uppercase; letter-spacing:.8px; color:var(--falcon-600);">
                            {{ $m['label'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@stop

@push('scripts')
    <script>
        function updateDomain(event, path = 'domain') {
            const newDomain = event.target.value;
            const url = new URL(window.location.href);
            url.searchParams.delete(path);
            if (newDomain) url.searchParams.set(path, newDomain);
            window.location.href = url.toString();
        }

        function updateDomainBtn(value, path = 'domain') {
            const url = new URL(window.location.href);
            url.searchParams.delete(path);
            if (value) url.searchParams.set(path, value);
            window.location.href = url.toString();
        }
    </script>
@endpush
