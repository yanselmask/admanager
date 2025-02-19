@extends('plugins/member::themes.dashboard.layouts.master')

@section('content')
    {!! apply_filters(MEMBER_TOP_STATISTIC_FILTER, null) !!}
        <x-core::stat-widget class="mb-3 row-cols-1 row-cols-sm-2 row-cols-md-3">
            @forelse($referrals as $ref)
                        <x-core::stat-widget.item
                            :label="$ref->first_name"
                            :value="$ref->username"
                            icon="ti ti-user"
                            color="secondary"
                        />
            @empty
                <x-core::stat-widget.item
                    :label="__('Sin referidos')"
                    value="{{__('Referir')}}"
                    icon="ti ti-user"
                    color="danger"
                    url="{{route('public.member.settings')}}"
                />
            @endforelse
        </x-core::stat-widget>
        {{$referrals->links()}}
@stop
