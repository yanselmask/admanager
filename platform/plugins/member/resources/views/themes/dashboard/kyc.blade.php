@extends('plugins/member::themes.dashboard.layouts.master')
@section('content')
    @if($user->kyc?->status->getValue() == 'pending')
        <h1>{{__('Su solicitud esta pendiente de aprobación')}}</h1>
    @else
        @if($user->kyc?->status->getValue() == 'draft')
            <div class="alert alert-danger">{{__('Su solicitud ha sido rechazada, vuevla a enviarla.')}}</div>
        @endif
    {!! $form !!}
    @endif
@stop
