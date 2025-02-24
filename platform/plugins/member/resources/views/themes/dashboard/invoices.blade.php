@extends('plugins/member::themes.dashboard.layouts.master')
@section('content')
    @if(count($invoices))
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('Invoice Number')}}</th>
            <th scope="col">{{__('Invoice Date')}}</th>
            <th scope="col">{{__('Invoice Amount')}}</th>
            <th scope="col">{{__('Notes')}}</th>
            <th scope="col">{{__('Status')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoices as $invoice)
        <tr>
            <th scope="row">{{$invoice->id}}</th>
            <td>{{$invoice->name}}</td>
            <td>{{$invoice->invoice_date?->format('M d, Y')}}</td>
            <td>{{str(get_currency_code($invoice->currency)['symbol'])->append(number_format($invoice->amount, 2))}}</td>
            <td>{{$invoice->getMetaData('notes', true)}}</td>
            <td>{!! \Botble\Member\Enums\InvoiceStatus::badge($invoice->status) !!}</td>
        </tr>
        @endforeach

        </tbody>
    </table>
        {{$invoices->links()}}
    @else
        <h3>{{__('Aún no tienes facturas generadas')}}</h3>
    @endif
@endsection
