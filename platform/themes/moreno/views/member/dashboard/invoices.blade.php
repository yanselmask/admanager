@extends('theme.moreno::views.member.dashboard.layouts.master')

@section('content')
    @php
        $invoiceCount = $invoices->total();
    @endphp

    <div class="moreno-dashboard-empty moreno-invoices-page">
        <section class="moreno-invoices-hero">
            <div class="moreno-invoices-hero-copy">
                <span class="moreno-dashboard-kicker">Resumen financiero</span>
                <h1>Historial de pagos</h1>
                <p>Consulta tus ingresos, revisa el estado de cada pago y mantén toda tu actividad financiera en un solo lugar.</p>
            </div>
            <div class="moreno-invoices-hero-mark" aria-hidden="true">
                <span class="fas fa-file-invoice-dollar"></span>
            </div>
        </section>

        @if($invoices->count())
            <section class="moreno-invoices-panel" aria-labelledby="moreno-invoices-title">
                <div class="moreno-invoices-panel-heading">
                    <div>
                        <span class="moreno-invoices-section-label">Actividad reciente</span>
                        <h2 id="moreno-invoices-title">Tus pagos</h2>
                    </div>
                    <div class="moreno-invoices-total">
                        <strong>{{ $invoiceCount }}</strong>
                        <span>{{ $invoiceCount === 1 ? 'documento' : 'documentos' }}</span>
                    </div>
                </div>

                <div class="moreno-invoices-table-wrap">
                    <table class="moreno-invoices-table">
                        <thead>
                            <tr>
                                <th scope="col">Periodo</th>
                                <th scope="col">Sitio</th>
                                <th scope="col">Ingresos</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                @php
                                    $invoiceNote = (string) $invoice->getMetaData('notes', true);
                                    $host = parse_url($invoiceNote, PHP_URL_HOST) ?: $invoiceNote;
                                    $displaySite = preg_replace('/^www\./', '', $host) ?: 'Sitio no especificado';
                                    $currency = get_currency_code($invoice->currency);
                                    $currencySymbol = is_array($currency) ? ($currency['symbol'] ?? '$') : '$';
                                    $statusMeta = match ($invoice->status) {
                                        'paid' => ['label' => 'Pagado', 'class' => 'is-paid'],
                                        'pending' => ['label' => 'Pendiente', 'class' => 'is-pending'],
                                        'unpaid' => ['label' => 'No pagado', 'class' => 'is-unpaid'],
                                        'partially_paid' => ['label' => 'Pago parcial', 'class' => 'is-partial'],
                                        default => ['label' => ucfirst((string) $invoice->status), 'class' => 'is-pending'],
                                    };
                                @endphp
                                <tr>
                                    <td data-label="Periodo">
                                        <div class="moreno-invoice-period">
                                            <strong>{{ $invoice->invoice_date?->format('M Y') ?: 'Sin fecha' }}</strong>
                                            <span>{{ $invoice->name }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Sitio">
                                        <div class="moreno-invoice-site">
                                            <span class="moreno-invoice-site-icon" aria-hidden="true"><span class="fas fa-globe"></span></span>
                                            <span>{{ $displaySite }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Ingresos">
                                        <strong class="moreno-invoice-amount">{{ $currencySymbol }}{{ number_format((float) $invoice->amount, 2) }}</strong>
                                    </td>
                                    <td data-label="Estado">
                                        <span class="moreno-invoice-status {{ $statusMeta['class'] }}">
                                            <span aria-hidden="true"></span>{{ $statusMeta['label'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($invoices->hasPages())
                    <div class="moreno-invoices-pagination">
                        {{ $invoices->links() }}
                    </div>
                @endif
            </section>
        @else
            <section class="moreno-invoices-empty" aria-labelledby="moreno-invoices-empty-title">
                <span class="moreno-invoices-empty-icon" aria-hidden="true"><span class="fas fa-receipt"></span></span>
                <h2 id="moreno-invoices-empty-title">Aún no tienes pagos registrados</h2>
                <p>Cuando se genere tu primer pago, podrás consultar aquí la fecha, el sitio asociado, el importe y su estado.</p>
                <a href="{{ route('public.member.settings') }}" class="moreno-dashboard-action">
                    Revisar mi cuenta <span aria-hidden="true">&rarr;</span>
                </a>
            </section>
        @endif
    </div>
@stop
