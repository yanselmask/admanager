@extends('theme.moreno::views.partner.dashboard._shell')

@section('subtitle', 'Cuentas asociadas en')

@section('panel')
    @if($accounts->isEmpty())
        <div class="moreno-invoices-panel">
            <p class="mb-0 text-center py-5">{{ trans('plugins/partner::partner.dashboard.no_networks') }}</p>
        </div>
    @else
        <section class="moreno-invoices-panel">
            <div class="moreno-invoices-panel-heading">
                <div>
                    <span class="moreno-invoices-section-label">Ad Manager</span>
                    <h2>{{ trans('plugins/partner::partner.dashboard.accounts') }}</h2>
                </div>
                <div class="moreno-invoices-total">
                    <strong>{{ $accounts->count() }}</strong>
                    <span>{{ $accounts->count() === 1 ? 'cuenta' : 'cuentas' }}</span>
                </div>
            </div>

            <div class="moreno-invoices-table-wrap">
                <table class="moreno-invoices-table">
                    <thead>
                        <tr>
                            <th scope="col">Cuenta</th>
                            <th scope="col">Dominios</th>
                            @if($visibleMetrics['earning'] ?? true)<th scope="col">Ganancias</th>@endif
                            @if($visibleMetrics['impressions'] ?? true)<th scope="col">Impresiones</th>@endif
                            @if($visibleMetrics['clicks'] ?? true)<th scope="col">Clicks</th>@endif
                            @if($visibleMetrics['ctrs'] ?? true)<th scope="col">CTR</th>@endif
                            @if($visibleMetrics['ecpms'] ?? true)<th scope="col">eCPM</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $row)
                            <tr>
                                <td data-label="Cuenta">
                                    <div class="moreno-invoice-period">
                                        <strong>{{ $row['network']->network_name }}</strong>
                                        <span>{{ $row['network']->network_code }}</span>
                                    </div>
                                </td>
                                <td data-label="Dominios">{{ $row['domains_count'] }}</td>
                                @if($visibleMetrics['earning'] ?? true)<td data-label="Ganancias"><strong class="moreno-invoice-amount">${{ number_format($row['metrics']->earning, 2) }}</strong></td>@endif
                                @if($visibleMetrics['impressions'] ?? true)<td data-label="Impresiones">{{ number_format($row['metrics']->impressions) }}</td>@endif
                                @if($visibleMetrics['clicks'] ?? true)<td data-label="Clicks">{{ number_format($row['metrics']->clicks) }}</td>@endif
                                @if($visibleMetrics['ctrs'] ?? true)<td data-label="CTR">{{ number_format($row['metrics']->ctr, 2) }}%</td>@endif
                                @if($visibleMetrics['ecpms'] ?? true)<td data-label="eCPM">${{ number_format($row['metrics']->ecpm, 2) }}</td>@endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endif
@endsection
