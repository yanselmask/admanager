@extends('theme.moreno::views.member.dashboard.layouts.master')

@php
    $hour = (int) now()->format('H');
    $greeting = $hour < 12 ? 'Buenos días' : ($hour < 18 ? 'Buenas tardes' : 'Buenas noches');
    $periodLabel = trans('plugins/partner::partner.periods.' . $period);
@endphp

@section('content')
    <div class="moreno-dashboard-analytics">
        <div class="moreno-analytics-welcome d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h4 class="mb-1 fw-bold">{{ $greeting }}, <span class="text-primary">{{ $partner->name }}</span></h4>
                <p class="mb-0 fs-10">
                    @yield('subtitle', 'Mostrando estadísticas de')
                    <span class="fw-semibold">{{ $periodLabel }}</span>
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="text-end me-2 d-none d-sm-block">
                    <p class="mb-0 fw-semibold fs-9">{{ $partner->name }}</p>
                    <p class="mb-0 fs-10">{{ $partner->email }}</p>
                </div>
                <img class="rounded-circle" src="{{ $partner->avatar_url }}" alt="{{ $partner->name }}"
                     style="width:44px; height:44px; object-fit:cover; border: 2px solid var(--ms-brand-bright);" />
            </div>
        </div>

        <div class="moreno-analytics-controls mb-4">
            @yield('filters')
            <div class="moreno-analytics-control moreno-analytics-control--period">
                <span>Período</span>
                <div class="moreno-analytics-periods">
                    @foreach($periods as $key)
                        <a class="moreno-analytics-period {{ $period === $key ? 'is-active' : '' }}"
                           href="{{ request()->fullUrlWithQuery(['period' => $key]) }}">
                            {{ trans('plugins/partner::partner.periods.' . $key) }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        @yield('panel')
    </div>
@endsection
