@extends('plugins/partner::themes.dashboard._layout')

@section('content')
    @if($accounts->isEmpty())
        <div class="empty">{{ trans('plugins/partner::partner.dashboard.no_networks') }}</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>{{ trans('plugins/partner::partner.networks.network_name') }}</th>
                    <th>{{ trans('plugins/partner::partner.networks.network_code') }}</th>
                    <th class="num">{{ trans('plugins/partner::partner.networks.domains_count') }}</th>
                    @if($visibleMetrics['earning'])<th class="num">{{ trans('plugins/partner::partner.dashboard.earning') }}</th>@endif
                    @if($visibleMetrics['impressions'])<th class="num">{{ trans('plugins/partner::partner.dashboard.impressions') }}</th>@endif
                    @if($visibleMetrics['clicks'])<th class="num">{{ trans('plugins/partner::partner.dashboard.clicks') }}</th>@endif
                    @if($visibleMetrics['ctrs'])<th class="num">{{ trans('plugins/partner::partner.dashboard.ctr') }}</th>@endif
                    @if($visibleMetrics['ecpms'])<th class="num">{{ trans('plugins/partner::partner.dashboard.ecpm') }}</th>@endif
                </tr>
            </thead>
            <tbody>
                @foreach($accounts as $row)
                    <tr>
                        <td>{{ $row['network']->network_name }}</td>
                        <td>{{ $row['network']->network_code }}</td>
                        <td class="num">{{ $row['domains_count'] }}</td>
                        @if($visibleMetrics['earning'])<td class="num">{{ number_format($row['metrics']->earning, 2) }}</td>@endif
                        @if($visibleMetrics['impressions'])<td class="num">{{ number_format($row['metrics']->impressions) }}</td>@endif
                        @if($visibleMetrics['clicks'])<td class="num">{{ number_format($row['metrics']->clicks) }}</td>@endif
                        @if($visibleMetrics['ctrs'])<td class="num">{{ number_format($row['metrics']->ctr, 2) }}%</td>@endif
                        @if($visibleMetrics['ecpms'])<td class="num">{{ number_format($row['metrics']->ecpm, 2) }}</td>@endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
