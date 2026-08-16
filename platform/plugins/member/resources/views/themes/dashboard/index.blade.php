@extends('plugins/member::themes.dashboard.layouts.master')

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

            $stats = [
                [
                    'icon'     => 'fas fa-dollar-sign',
                    'label'    => 'Ganancias',
                    'value'    => '$' . number_format((float) $cards['earning'], 2),
                    'gradient' => 'linear-gradient(135deg, #1a55a8 0%, #2a7ae4 100%)',
                    'shadow'   => 'rgba(42,122,228,0.35)',
                    'popover'  => $earningsPopover,
                ],
                [
                    'icon'     => 'fas fa-chart-bar',
                    'label'    => 'Impresiones',
                    'value'    => number_format((float) $cards['impressions'], 0),
                    'gradient' => 'linear-gradient(135deg, #6019a3 0%, #9b59b6 100%)',
                    'shadow'   => 'rgba(155,89,182,0.35)',
                    'popover'  => null,
                ],
                [
                    'icon'     => 'fas fa-money-bill',
                    'label'    => 'eCPM',
                    'value'    => '$' . $cards['ecpms'],
                    'gradient' => 'linear-gradient(135deg, #0a6e7a 0%, #12aabf 100%)',
                    'shadow'   => 'rgba(18,170,191,0.35)',
                    'popover'  => null,
                ],
                [
                    'icon'     => 'fas fa-mouse-pointer',
                    'label'    => 'Clicks',
                    'value'    => number_format((float) $cards['clicks'], 0),
                    'gradient' => 'linear-gradient(135deg, #0d6e3f 0%, #27ae60 100%)',
                    'shadow'   => 'rgba(39,174,96,0.35)',
                    'popover'  => null,
                ],
                [
                    'icon'     => 'fas fa-chart-line',
                    'label'    => 'CTR',
                    'value'    => $cards['ctrs'] ?: '0.00%',
                    'gradient' => 'linear-gradient(135deg, #b25700 0%, #e8820c 100%)',
                    'shadow'   => 'rgba(232,130,12,0.35)',
                    'popover'  => null,
                ],
                [
                    'icon'     => 'fas fa-donate',
                    'label'    => 'CPC',
                    'value'    => '$' . ($cards['cpc'] ?: '0.00'),
                    'gradient' => 'linear-gradient(135deg, #922b21 0%, #e74c3c 100%)',
                    'shadow'   => 'rgba(231,76,60,0.35)',
                    'popover'  => null,
                ],
            ];
        @endphp

        {{-- Welcome Header --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h4 class="mb-1 fw-bold">{{ $greeting }}, <span class="text-primary">{{ $user->name }}</span></h4>
                <p class="mb-0 fs-10" style="color: var(--falcon-600);">
                    Mostrando estadísticas de
                    <span class="fw-semibold" style="color: var(--falcon-body-color);">{{ $periodLabel }}</span>
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="text-end me-2 d-none d-sm-block">
                    <p class="mb-0 fw-semibold fs-9" style="color: var(--falcon-body-color);">{{ $user->name }}</p>
                    <p class="mb-0 fs-10" style="color: var(--falcon-600);">{{ $user->email }}</p>
                </div>
                <img class="rounded-circle" src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                     style="width:44px; height:44px; object-fit:cover; border: 2px solid var(--falcon-primary);" />
            </div>
        </div>

        {{-- Filter Toolbar --}}
        <div class="card border-0 mb-4" style="border-radius:14px; box-shadow: 0 2px 16px rgba(0,0,0,0.08);">
            <div class="card-body py-3 px-4">
                <div class="row align-items-end g-3">
                    <div class="col-12 col-md-auto" style="min-width:220px;">
                        <label class="form-label mb-1 fw-semibold text-uppercase"
                               style="font-size:0.68rem; letter-spacing:0.6px; color:var(--falcon-600);">
                            Dominio
                        </label>
                        <select id="domain" onchange="updateDomain(event)" class="form-select form-select-sm" style="border-radius:8px;">
                            @foreach($user->domains as $dname)
                                <option @selected(request()->query('domain') == $dname->url) value="{{ $dname->url }}">
                                    {{ $dname->name }}
                                </option>
                            @endforeach
                            <option value="any" @selected(request()->query('domain') == 'any')>Todos los dominios</option>
                        </select>
                    </div>
                    <div class="col-12 col-md">
                        <label class="form-label mb-1 fw-semibold text-uppercase"
                               style="font-size:0.68rem; letter-spacing:0.6px; color:var(--falcon-600);">
                            Período
                        </label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($periodLabels as $key => $lbl)
                                <button
                                    class="btn btn-sm {{ $currentPeriod === $key ? 'btn-primary' : 'btn-falcon-default' }}"
                                    onclick="updateDomainBtn('{{ $key }}', 'period')"
                                    type="button"
                                    style="border-radius:20px; font-size:0.77rem; padding:0.25rem 0.85rem; white-space:nowrap;"
                                >{{ $lbl }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="row g-3 mb-4">
            @foreach($stats as $stat)
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card h-100 border-0 overflow-hidden"
                         style="background: {{ $stat['gradient'] }}; border-radius:16px; box-shadow: 0 6px 24px {{ $stat['shadow'] }};">
                        <div class="card-body p-4 position-relative">
                            @if($stat['popover'])
                                <div class="position-absolute top-0 end-0 me-3 mt-3"
                                     style="cursor:pointer; z-index:2;"
                                     data-bs-container="body"
                                     data-bs-toggle="popover"
                                     data-bs-placement="top"
                                     data-bs-content="{{ $stat['popover'] }}">
                                    <span class="fas fa-info-circle text-white" style="opacity:0.75; font-size:0.9rem;"></span>
                                </div>
                            @endif

                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="background:rgba(255,255,255,0.18); border-radius:12px; width:46px; height:46px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    <span class="{{ $stat['icon'] }} text-white" style="font-size:1.1rem;"></span>
                                </div>
                                <span class="text-white fw-semibold text-uppercase"
                                      style="font-size:0.7rem; letter-spacing:1px; opacity:0.85;">
                                    {{ $stat['label'] }}
                                </span>
                            </div>

                            <h2 class="text-white fw-bold mb-0" style="font-size:2rem; letter-spacing:-0.5px;">
                                {{ $stat['value'] }}
                            </h2>

                            <div class="position-absolute" style="bottom:-12px; right:-12px; pointer-events:none;">
                                <span class="{{ $stat['icon'] }}" style="font-size:7rem; color:rgba(255,255,255,0.07);"></span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Poster Banner --}}
        <div class="row mb-3">
            <div class="col-12">
                <div class="card border-0 overflow-hidden" style="border-radius:16px; box-shadow:0 2px 16px rgba(0,0,0,0.12);">
                    <img src="{{ asset('custom/amauri/img/poster.png') }}" alt="{{ __('Poster') }}"
                         class="img-fluid w-100" style="object-fit:cover; display:block;" />
                </div>
            </div>
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
