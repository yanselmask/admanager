@extends('theme.moreno::views.member.dashboard.layouts.master')

@section('content')
    {!! apply_filters(MEMBER_TOP_STATISTIC_FILTER, null) !!}

    @if($user->domains->count())
        <div class="moreno-dashboard-analytics">
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

            $stats = [
                [
                    'icon'     => 'fas fa-dollar-sign',
                    'label'    => 'Ganancias',
                    'value'    => '$' . number_format((float) $cards['earning'], 2),
                    'gradient' => 'linear-gradient(135deg, #12498D 0%, #2879D2 100%)',
                    'shadow'   => 'rgba(42,122,228,0.25)',
                    'popover'  => $earningsPopover,
                ],
                [
                    'icon'     => 'fas fa-chart-bar',
                    'label'    => 'Impresiones',
                    'value'    => number_format((float) $cards['impressions'], 0),
                    'gradient' => 'linear-gradient(135deg, #10375F 0%, #2869A7 100%)',
                    'shadow'   => 'rgba(40,105,167,0.25)',
                    'popover'  => null,
                ],
                [
                    'icon'     => 'fas fa-money-bill',
                    'label'    => 'eCPM',
                    'value'    => '$' . $cards['ecpms'],
                    'gradient' => 'linear-gradient(135deg, #1B5680 0%, #2C8AB7 100%)',
                    'shadow'   => 'rgba(44,138,183,0.22)',
                    'popover'  => null,
                ],
                [
                    'icon'     => 'fas fa-mouse-pointer',
                    'label'    => 'Clicks',
                    'value'    => number_format((float) $cards['clicks'], 0),
                    'gradient' => 'linear-gradient(135deg, #145A5D 0%, #2C9388 100%)',
                    'shadow'   => 'rgba(44,147,136,0.22)',
                    'popover'  => null,
                ],
                [
                    'icon'     => 'fas fa-chart-line',
                    'label'    => 'CTR',
                    'value'    => $cards['ctrs'] ?: '0.00%',
                    'gradient' => 'linear-gradient(135deg, #765C26 0%, #B38731 100%)',
                    'shadow'   => 'rgba(179,135,49,0.2)',
                    'popover'  => null,
                ],
                [
                    'icon'     => 'fas fa-donate',
                    'label'    => 'CPC',
                    'value'    => '$' . ($cards['cpc'] ?: '0.00'),
                    'gradient' => 'linear-gradient(135deg, #344A6C 0%, #637A9E 100%)',
                    'shadow'   => 'rgba(99,122,158,0.22)',
                    'popover'  => null,
                ],
            ];
        @endphp

        {{-- Welcome Header --}}
        <div class="moreno-analytics-welcome d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h4 class="mb-1 fw-bold">{{ $greeting }}, <span class="text-primary">{{ $user->name }}</span></h4>
                <p class="mb-0 fs-10">
                    Mostrando estadísticas de
                    <span class="fw-semibold">{{ $periodLabel }}</span>
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="text-end me-2 d-none d-sm-block">
                    <p class="mb-0 fw-semibold fs-9">{{ $user->name }}</p>
                    <p class="mb-0 fs-10">{{ $user->email }}</p>
                </div>
                <img class="rounded-circle" src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                     style="width:44px; height:44px; object-fit:cover; border: 2px solid var(--ms-brand-bright);" />
            </div>
        </div>

        {{-- Filter Toolbar --}}
        <div class="moreno-analytics-controls mb-4">
            <div class="moreno-analytics-control moreno-analytics-control--domain">
                <label for="domain">Dominio</label>
                <select id="domain" onchange="updateDomain(event)" class="form-select moreno-analytics-select">
                    @foreach($user->domains as $dname)
                        <option @selected(request()->query('domain') == $dname->url) value="{{ $dname->url }}">
                            {{ $dname->name }}
                        </option>
                    @endforeach
                    <option value="any" @selected(request()->query('domain') == 'any')>Todos los dominios</option>
                </select>
            </div>
            <div class="moreno-analytics-control moreno-analytics-control--period">
                <span>Período</span>
                <div class="moreno-analytics-periods">
                    @foreach($periodLabels as $key => $lbl)
                        <button
                            class="moreno-analytics-period {{ $currentPeriod === $key ? 'is-active' : '' }}"
                            onclick="updateDomainBtn('{{ $key }}', 'period')"
                            type="button"
                        >{{ $lbl }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="row g-3 mb-4">
            @foreach($stats as $stat)
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card h-100 border-0 overflow-hidden moreno-legacy-stat-card"
                         style="background: {{ $stat['gradient'] }}; box-shadow: 0 6px 24px {{ $stat['shadow'] }};">
                        <div class="card-body p-4 position-relative">
                            @if($stat['popover'])
                                <div class="position-absolute top-0 end-0 me-3 mt-3 moreno-legacy-stat-info"
                                     data-bs-container="body"
                                     data-bs-toggle="popover"
                                     data-bs-placement="top"
                                     data-bs-content="{{ $stat['popover'] }}">
                                    <span class="fas fa-info-circle" aria-hidden="true"></span>
                                </div>
                            @endif

                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="moreno-legacy-stat-icon">
                                    <span class="{{ $stat['icon'] }}" aria-hidden="true"></span>
                                </div>
                                <span class="moreno-legacy-stat-label">{{ $stat['label'] }}</span>
                            </div>

                            <h2 class="moreno-legacy-stat-value">
                                {{ $stat['value'] }}
                            </h2>

                            <div class="position-absolute moreno-legacy-stat-mark" aria-hidden="true">
                                <span class="{{ $stat['icon'] }}"></span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        </div>
    @else
        @php
            $hour = (int) now()->format('H');
            $greeting = $hour < 12 ? 'Buenos días' : ($hour < 18 ? 'Buenas tardes' : 'Buenas noches');
        @endphp

        <div class="moreno-dashboard-empty">
            <section class="moreno-dashboard-welcome mb-4">
                <div>
                    <span class="moreno-dashboard-kicker">Panel de creador</span>
                    <h1>{{ $greeting }}, {{ $user->name }}</h1>
                    <p>Tu cuenta está lista. Conecta tu primera web para empezar a visualizar ingresos, tráfico y rendimiento.</p>
                    <a href="{{ route('public.member.settings') }}" class="moreno-dashboard-action">
                        Configurar mi cuenta <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
                <div class="moreno-dashboard-welcome-mark" aria-hidden="true">
                    <span class="fas fa-chart-line"></span>
                </div>
            </section>

            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <div class="moreno-dashboard-summary-card h-100">
                        <span class="fas fa-check-circle moreno-dashboard-summary-icon"></span>
                        <span class="moreno-dashboard-summary-label">Estado de cuenta</span>
                        <strong>Activa</strong>
                        <small>Tu acceso está habilitado</small>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="moreno-dashboard-summary-card h-100">
                        <span class="fas fa-globe moreno-dashboard-summary-icon"></span>
                        <span class="moreno-dashboard-summary-label">Webs conectadas</span>
                        <strong>0</strong>
                        <small>Añade una web para comenzar</small>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="moreno-dashboard-summary-card h-100">
                        <span class="fas fa-wallet moreno-dashboard-summary-icon"></span>
                        <span class="moreno-dashboard-summary-label">Pagos</span>
                        <strong>Preparado</strong>
                        <small>Tu historial aparecerá aquí</small>
                    </div>
                </div>
            </div>

            <section class="moreno-dashboard-next-steps">
                <div>
                    <span class="moreno-dashboard-kicker">Siguiente paso</span>
                    <h2>Empieza a monetizar tu contenido</h2>
                    <p>Completa tu perfil y comparte tu información para que podamos preparar tu primera oportunidad de monetización.</p>
                </div>
                <div class="moreno-dashboard-step-list">
                    <a href="{{ route('public.member.settings') }}" class="moreno-dashboard-step">
                        <span>01</span>
                        <div><strong>Completa tu perfil</strong><small>Agrega tus datos y preferencias</small></div>
                        <b aria-hidden="true">&rarr;</b>
                    </a>
                    <a href="{{ route('public.member.referrals') }}" class="moreno-dashboard-step">
                        <span>02</span>
                        <div><strong>Invita a tu red</strong><small>Consulta tu enlace de referidos</small></div>
                        <b aria-hidden="true">&rarr;</b>
                    </a>
                </div>
            </section>
        </div>
    @endif
@stop

@push('scripts-libs')
    <script src="{{ asset('custom/amauri/vendors/chart/chart.umd.js') }}"></script>
@endpush

@push('scripts')
    <script>
        function updateDomain(event, path = 'domain') {
            const newDomain = event.target.value;
            const url = new URL(window.location.href);
            url.searchParams.delete(path);
            if (newDomain) {
                url.searchParams.set(path, newDomain);
            }
            window.location.href = url.toString();
        }

        function updateDomainBtn(value, path = 'domain') {
            const url = new URL(window.location.href);
            url.searchParams.delete(path);
            if (value) {
                url.searchParams.set(path, value);
            }
            window.location.href = url.toString();
        }
    </script>
@endpush
