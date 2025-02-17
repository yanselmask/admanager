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
    </div>
    <x-core::stat-widget class="mb-3 row-cols-1 row-cols-sm-2 row-cols-md-3">
        <x-core::stat-widget.item
            :label="trans('Ganancias de hoy')"
            :value="$domain->getEarning('today')"
            icon="ti ti-cash-banknote"
            color="secondary"
        />
        <x-core::stat-widget.item
            :label="trans('Ganancias de ayer')"
            :value="$domain->getEarning('yesterday')"
            icon="ti ti-cash-banknote"
            color="secondary"
        />
        <x-core::stat-widget.item
            :label="trans('Ganancias de esta semana')"
            :value="$domain->getEarning('this_week')"
            icon="ti ti-cash-banknote"
            color="secondary"
        />
        <x-core::stat-widget.item
            :label="trans('Ganancias de este mes')"
            :value="$domain->getEarning('this_month')"
            icon="ti ti-cash-banknote"
            color="secondary"
        />
        <x-core::stat-widget.item
            :label="trans('Ganancias del més pasado')"
            :value="$domain->getEarning('last_month')"
            icon="ti ti-cash-banknote"
            color="secondary"
        />
        <x-core::stat-widget.item
            :label="trans('Ganancias de la semana pasada')"
            :value="$domain->getEarning('last_week')"
            icon="ti ti-cash-banknote"
            color="secondary"
        />
        <x-core::stat-widget.item
            :label="trans('Ganancias de los ultimos 3 meses')"
            :value="$domain->getEarning('last_3_months')"
            icon="ti ti-cash-banknote"
            color="secondary"
        />
        <x-core::stat-widget.item
            :label="trans('Ganancias de los ultimos 6 meses')"
            :value="$domain->getEarning('last_6_months')"
            icon="ti ti-cash-banknote"
            color="secondary"
        />
        <x-core::stat-widget.item
            :label="trans('Ganancias de los ultimos 9 meses')"
            :value="$domain->getEarning('last_9_months')"
            icon="ti ti-cash-banknote"
            color="secondary"
        />
    </x-core::stat-widget>
    <x-core::stat-widget class="mb-3 row-cols-1 row-cols-sm-2 row-cols-md-3">
        <x-core::stat-widget.item
            :label="trans('Impresiones de hoy')"
            :value="$domain->getImpressions('today')"
            icon="ti ti-timeline"
            color="info"
        />
        <x-core::stat-widget.item
            :label="trans('Impresiones de ayer')"
            :value="$domain->getImpressions('yesterday')"
            icon="ti ti-timeline"
            color="info"
        />
        <x-core::stat-widget.item
            :label="trans('Impresiones del mes pasado')"
            :value="$domain->getImpressions('last_month')"
            icon="ti ti-timeline"
            color="info"
        />
    </x-core::stat-widget>
    <x-core::stat-widget class="mb-3 row-cols-1 row-cols-sm-2 row-cols-md-3">
        <x-core::stat-widget.item
            :label="trans('Clicks de hoy')"
            :value="$domain->getClicks('today')"
            icon="ti ti-click"
            color="primary"
        />
        <x-core::stat-widget.item
            :label="trans('Clicks de ayer')"
            :value="$domain->getClicks('yesterday')"
            icon="ti ti-click"
            color="primary"
        />
        <x-core::stat-widget.item
            :label="trans('Clicks del mes pasado')"
            :value="$domain->getClicks('last_month')"
            icon="ti ti-click"
            color="primary"
        />
    </x-core::stat-widget>
    <x-core::stat-widget class="mb-3 row-cols-1 row-cols-sm-2 row-cols-md-3">
        <x-core::stat-widget.item
            :label="trans('Ctrs de hoy')"
            :value="$domain->getCtrs('today')"
            icon="ti ti-hand-click"
            color="danger"
        />
        <x-core::stat-widget.item
            :label="trans('Ctrs de ayer')"
            :value="$domain->getCtrs('yesterday')"
            icon="ti ti-hand-click"
            color="danger"
        />
        <x-core::stat-widget.item
            :label="trans('Ctrs del mes pasado')"
            :value="$domain->getCtrs('last_month')"
            icon="ti ti-hand-click"
            color="danger"
        />
    </x-core::stat-widget>
    <x-core::stat-widget class="mb-3 row-cols-1 row-cols-sm-2 row-cols-md-3">
    <x-core::stat-widget.item
        :label="trans('Ecpms de hoy')"
        :value="$domain->getEcpms('today')"
        icon="ti ti-moneybag"
        color="warning"
    />
    <x-core::stat-widget.item
        :label="trans('Ecpms de ayer')"
        :value="$domain->getEcpms('yesterday')"
        icon="ti ti-moneybag"
        color="warning"
    />
    <x-core::stat-widget.item
        :label="trans('Ecpms del mes pasado')"
        :value="$domain->getEcpms('last_month')"
        icon="ti ti-moneybag"
        color="warning"
    />
</x-core::stat-widget>
    @endif
    <activity-log-component></activity-log-component>
@stop
@push('scripts')
    <script>
        function updateDomain(event) {
            const newDomain = event.target.value;
            const url = new URL(window.location.href);

            url.searchParams.delete('domain');

            if (newDomain) {
                url.searchParams.set('domain', newDomain);
            }

            window.location.href = url.toString();
        }
    </script>
@endpush
