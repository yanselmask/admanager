@extends('theme.amauri::views.member.dashboard.layouts.master')
@section('content')
        <div class="row g-0 h-100">
            <div class="col-12 mb-3">
                <div class="card bg-body-tertiary dark__bg-opacity-50 shadow-none">
                    <div class="d-flex align-items-center z-1 p-0">
                        <div class="">
                            <h4 class="mb-0 text-info fw-bold text-center text-md-start" style="font-size: 2.5rem">Historial de pagos</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(count($invoices))
            <table class="table">
                <thead>
                <tr>
{{--                    <th scope="col">#</th>--}}
                    <th scope="col">{{__('Mes')}}</th>
                    <th scope="col">{{__('Sitio')}}</th>
                    <th scope="col">{{__('Ingresos')}}</th>
                    <th scope="col">{{__('Estado')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoices as $invoice)
                    @php
                        $invoiceNote = $invoice->getMetaData('notes', true);
                        $host = parse_url($invoiceNote, PHP_URL_HOST) ?: $invoiceNote;
                        $parts = explode('.', $host);
                        $displaySite = count($parts) > 2
                            ? implode('.', array_slice($parts, 0, count($parts) - 2))
                            : $host;
                    @endphp
                    <tr>
                        <td>{{$invoice->invoice_date?->format('M')}}</td>
                        <td>{{ $displaySite ?: $invoiceNote }}</td>
                        <td>{{str(isset(get_currency_code($invoice->currency)['symbol']) ? get_currency_code($invoice->currency)['symbol'] : 'USD`')->append(number_format($invoice->amount, 2))}}</td>
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
