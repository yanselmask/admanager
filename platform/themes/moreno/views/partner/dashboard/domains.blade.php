@extends('theme.moreno::views.partner.dashboard._shell')

@section('subtitle', 'Dominios de tus cuentas en')

@section('filters')
    @if($networks->isNotEmpty())
        <div class="moreno-analytics-control moreno-analytics-control--domain">
            <label for="network">Cuenta</label>
            <select id="network" class="form-select moreno-analytics-select"
                    onchange="window.location = this.value">
                <option value="{{ request()->fullUrlWithQuery(['network' => 'any']) }}" @selected($selectedNetwork === null)>
                    {{ trans('plugins/partner::partner.dashboard.all_accounts') }}
                </option>
                @foreach($networks as $code => $network)
                    <option value="{{ request()->fullUrlWithQuery(['network' => $code]) }}" @selected($selectedNetwork === (string) $code)>
                        {{ $network->network_name }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif
@endsection

@section('panel')
    @if($domains->isEmpty())
        <div class="moreno-invoices-panel">
            <p class="mb-0 text-center py-5">
                {{ $networks->isEmpty()
                    ? trans('plugins/partner::partner.dashboard.no_networks')
                    : trans('plugins/partner::partner.dashboard.no_domains') }}
            </p>
        </div>
    @else
        <section class="moreno-invoices-panel">
            <div class="moreno-invoices-panel-heading">
                <div>
                    <span class="moreno-invoices-section-label">Inventario</span>
                    <h2>{{ trans('plugins/partner::partner.dashboard.domains') }}</h2>
                </div>
                <div class="moreno-invoices-total">
                    <strong>{{ $domains->total() }}</strong>
                    <span>{{ $domains->total() === 1 ? 'dominio' : 'dominios' }}</span>
                </div>
            </div>

            <div class="moreno-invoices-table-wrap">
                <table class="moreno-invoices-table">
                    <thead>
                        <tr>
                            <th scope="col">Dominio</th>
                            <th scope="col">Cuenta</th>
                            <th scope="col">Estado</th>
                            @if($visibleMetrics['earning'] ?? true)<th scope="col">Ganancias</th>@endif
                            @if($visibleMetrics['impressions'] ?? true)<th scope="col">Impresiones</th>@endif
                            @if($visibleMetrics['clicks'] ?? true)<th scope="col">Clicks</th>@endif
                            @if($visibleMetrics['ctrs'] ?? true)<th scope="col">CTR</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($domains as $domain)
                            @php($m = $metricsOf($domain))
                            <tr>
                                <td data-label="Dominio">
                                    <div class="moreno-invoice-site">
                                        <span class="moreno-invoice-site-icon" aria-hidden="true"><span class="fas fa-globe"></span></span>
                                        <span>{{ $domain->url }}</span>
                                    </div>
                                </td>
                                <td data-label="Cuenta">{{ optional($networks->get($domain->network_code))->network_name ?? $domain->network_code }}</td>
                                <td data-label="Estado">{!! $domain->status?->toHtml() !!}</td>
                                @if($visibleMetrics['earning'] ?? true)<td data-label="Ganancias"><strong class="moreno-invoice-amount">${{ number_format($m->earning, 2) }}</strong></td>@endif
                                @if($visibleMetrics['impressions'] ?? true)<td data-label="Impresiones">{{ number_format($m->impressions) }}</td>@endif
                                @if($visibleMetrics['clicks'] ?? true)<td data-label="Clicks">{{ number_format($m->clicks) }}</td>@endif
                                @if($visibleMetrics['ctrs'] ?? true)<td data-label="CTR">{{ number_format($m->ctr, 2) }}%</td>@endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">{{ $domains->links() }}</div>
        </section>
    @endif
@endsection
