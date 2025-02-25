@extends('plugins/member::themes.dashboard.layouts.master')

@section('content')
    {!! apply_filters(MEMBER_TOP_STATISTIC_FILTER, null) !!}
    @if($user->domains->count())
    <div class="row justify-content-center mb-3">
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label for="domain">{{__('Seleccione un dominio')}}</label>
                <select id="domain" onchange="updateDomain(event)" class="form-control">
                    @foreach($user->domains as $dname)
                        <option @selected(request()->query('domain') == $dname->url) value="{{$dname->url}}">{{$dname->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label for="graf">{{__('Seleccione un grafico')}}</label>
                <select id="graf" onchange="updateDomain(event, 'graf')" class="form-control">
                    @foreach($optionsGraf as $graf)
                        <option @selected(request()->query('graf') == $graf) value="{{$graf}}">{{ucfirst($graf)}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @if(json_decode(setting('earning_member')) && (request()->query('graf') == '' || request()->query('graf') == 'ganancias'))
    <x-core::stat-widget class="mb-3 row-cols-1 row-cols-sm-2 row-cols-md-3">
        @foreach(json_decode(setting('earning_member')) as $key)
            <x-core::stat-widget.item
                :label="trans('Ganancias de :key',['key' => ucfirst(str_replace('_', ' ', $key))])"
                :value="$domain->getEarning($key)"
                :value2="$domain->commissions_network ? __('Ganancias de la network: :earning',['earning' => $domain->getEarningInverse($key, $domain->commissions_network)]) : false"
                :value3="$domain->commissions_network ? __('Ganancias de la plataforma: :earning',['earning' => $domain->getEarningInverse($key, ($domain->commissions - $domain->commissions_network))]) : false"
                icon="ti ti-cash-banknote"
                color="secondary"
            />
        @endforeach
    </x-core::stat-widget>
    @endif
    @if(json_decode(setting('impressions_member')) && request()->query('graf') == 'impresiones')
    <x-core::stat-widget class="mb-3 row-cols-1 row-cols-sm-2 row-cols-md-3">
        @foreach(json_decode(setting('impressions_member')) as $key)
            <x-core::stat-widget.item
                :label="trans('Impresiones de :key', ['key' => ucfirst(str_replace('_', ' ', $key))])"
                :value="$domain->getImpressions($key)"
                icon="ti ti-timeline"
                color="info"
            />
        @endforeach
    </x-core::stat-widget>
    @endif
    @if(json_decode(setting('clicks_member')) && request()->query('graf') == 'clicks')
    <x-core::stat-widget class="mb-3 row-cols-1 row-cols-sm-2 row-cols-md-3">
        @foreach(json_decode(setting('clicks_member')) as $key)
            <x-core::stat-widget.item
                :label="trans('Clicks de :key',['key' => ucfirst(str_replace('_', ' ', $key))])"
                :value="$domain->getClicks($key)"
                icon="ti ti-click"
                color="primary"
            />
        @endforeach
    </x-core::stat-widget>
    @endif
    @if(json_decode(setting('ctrs_member')) && request()->query('graf') == 'ctrs')
    <x-core::stat-widget class="mb-3 row-cols-1 row-cols-sm-2 row-cols-md-3">
        @foreach(json_decode(setting('ctrs_member')) as $key)
            <x-core::stat-widget.item
                :label="trans('Ctrs de :key',['key' => ucfirst(str_replace('_', ' ', $key))])"
                :value="$domain->getCtrs($key)"
                icon="ti ti-hand-click"
                color="danger"
            />
        @endforeach
    </x-core::stat-widget>
    @endif
    @if(json_decode(setting('ecpms_member')) && request()->query('graf') == 'ecpm')
    <x-core::stat-widget class="mb-3 row-cols-1 row-cols-sm-2 row-cols-md-3">
        @foreach(json_decode(setting('ecpms_member')) as $key)
            <x-core::stat-widget.item
                :label="trans('Ecpm de :key',['key' => ucfirst(str_replace('_', ' ', $key))])"
                :value="$domain->getEcpms($key)"
                icon="ti ti-moneybag"
                color="warning"
            />
        @endforeach
</x-core::stat-widget>
    @endif
    @endif
@stop
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
    </script>
@endpush
