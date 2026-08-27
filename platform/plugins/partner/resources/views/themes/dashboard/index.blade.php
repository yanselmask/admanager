@extends('plugins/partner::themes.dashboard._layout')

@section('content')
    @include('plugins/partner::themes.dashboard._cards', ['metrics' => $metrics, 'visibleMetrics' => $visibleMetrics])

    @if($networks->isEmpty())
        <div class="empty">{{ trans('plugins/partner::partner.dashboard.no_networks') }}</div>
    @elseif($visibleMetrics['earning'])
        <table>
            <thead>
                <tr>
                    <th>{{ trans('plugins/partner::partner.dashboard.period') }}</th>
                    <th class="num">{{ trans('plugins/partner::partner.dashboard.earning') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($series as $key => $value)
                    <tr>
                        <td>{{ trans('plugins/partner::partner.periods.' . $key) }}</td>
                        <td class="num">{{ number_format($value, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
