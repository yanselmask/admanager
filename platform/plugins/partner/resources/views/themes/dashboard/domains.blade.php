@extends('plugins/partner::themes.dashboard._layout')

@section('content')
    @if($networks->isNotEmpty())
        <div class="periods">
            <a href="{{ request()->fullUrlWithQuery(['network' => 'any']) }}" class="{{ $selectedNetwork === null ? 'active' : '' }}">
                {{ trans('plugins/partner::partner.dashboard.all_accounts') }}
            </a>
            @foreach($networks as $code => $network)
                <a href="{{ request()->fullUrlWithQuery(['network' => $code]) }}" class="{{ $selectedNetwork === (string) $code ? 'active' : '' }}">
                    {{ $network->network_name }}
                </a>
            @endforeach
        </div>
    @endif

    @if($domains->isEmpty())
        <div class="empty">
            {{ $networks->isEmpty()
                ? trans('plugins/partner::partner.dashboard.no_networks')
                : trans('plugins/partner::partner.dashboard.no_domains') }}
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>{{ trans('plugins/partner::partner.dashboard.domain') }}</th>
                    <th>{{ trans('plugins/partner::partner.networks.network_name') }}</th>
                    <th>{{ trans('core/base::tables.status') }}</th>
                    @if($visibleMetrics['earning'])<th class="num">{{ trans('plugins/partner::partner.dashboard.earning') }}</th>@endif
                    @if($visibleMetrics['impressions'])<th class="num">{{ trans('plugins/partner::partner.dashboard.impressions') }}</th>@endif
                    @if($visibleMetrics['clicks'])<th class="num">{{ trans('plugins/partner::partner.dashboard.clicks') }}</th>@endif
                    @if($visibleMetrics['ctrs'])<th class="num">{{ trans('plugins/partner::partner.dashboard.ctr') }}</th>@endif
                </tr>
            </thead>
            <tbody>
                @foreach($domains as $domain)
                    @php($m = $metricsOf($domain))
                    <tr>
                        <td>{{ $domain->url }}</td>
                        <td>{{ optional($networks->get($domain->network_code))->network_name ?? $domain->network_code }}</td>
                        <td>{{ $domain->status?->label() ?? $domain->status }}</td>
                        @if($visibleMetrics['earning'])<td class="num">{{ number_format($m->earning, 2) }}</td>@endif
                        @if($visibleMetrics['impressions'])<td class="num">{{ number_format($m->impressions) }}</td>@endif
                        @if($visibleMetrics['clicks'])<td class="num">{{ number_format($m->clicks) }}</td>@endif
                        @if($visibleMetrics['ctrs'])<td class="num">{{ number_format($m->ctr, 2) }}%</td>@endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">{{ $domains->links() }}</div>
    @endif
@endsection
