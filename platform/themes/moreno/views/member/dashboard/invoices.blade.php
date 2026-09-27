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

        @php
            $paymentTypes = \Botble\Member\Enums\PaymentMethodType::cases();
            $selectedPaymentType = old('type', $paymentTypes[0]->value);
            $canAddPaymentMethod = $paymentMethods->count() < \Botble\Member\Http\Controllers\PaymentMethodController::MAX_METHODS;
        @endphp

        <section class="moreno-invoices-panel moreno-payment-methods" id="metodos-de-pago" aria-labelledby="moreno-payment-methods-title">
            <div class="moreno-invoices-panel-heading">
                <div>
                    <span class="moreno-invoices-section-label">Cómo quieres cobrar</span>
                    <h2 id="moreno-payment-methods-title">Métodos de pago</h2>
                </div>
            </div>

            @if($paymentMethods->isNotEmpty())
                <ul class="moreno-payment-method-list">
                    @foreach($paymentMethods as $paymentMethod)
                        <li @class(['moreno-payment-method', 'is-default' => $paymentMethod->is_default])>
                            <span class="moreno-payment-method-icon" aria-hidden="true"><span class="{{ $paymentMethod->type->icon() }}"></span></span>
                            <div class="moreno-payment-method-body">
                                <strong>{{ $paymentMethod->type->label() }}</strong>
                                <span>{{ $paymentMethod->summary }}</span>
                            </div>
                            <div class="moreno-payment-method-actions">
                                @if($paymentMethod->is_default)
                                    <span class="moreno-payment-method-badge">Predeterminado</span>
                                @else
                                    <form method="POST" action="{{ route('public.member.payment-methods.default', $paymentMethod->getKey()) }}">
                                        @csrf
                                        <button type="submit" class="moreno-payment-method-link">Usar este</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('public.member.payment-methods.destroy', $paymentMethod->getKey()) }}" onsubmit="return confirm('¿Eliminar este método de pago?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="moreno-payment-method-remove" aria-label="Eliminar {{ $paymentMethod->type->label() }}">
                                        <span class="fas fa-trash-alt" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="moreno-payment-methods-empty">Aún no tienes métodos de pago. Agrega uno para que sepamos dónde enviarte tus ingresos.</p>
            @endif

            @if($canAddPaymentMethod)
                <details class="moreno-payment-method-add" @if($errors->any() || $paymentMethods->isEmpty()) open @endif>
                    <summary><span class="fas fa-plus" aria-hidden="true"></span> Agregar método de pago</summary>

                    <form method="POST" action="{{ route('public.member.payment-methods.store') }}" class="moreno-payment-method-form" data-payment-method-form>
                        @csrf

                        <label class="moreno-payment-field">
                            <span>Tipo</span>
                            <select name="type" data-payment-method-type required>
                                @foreach($paymentTypes as $paymentType)
                                    <option value="{{ $paymentType->value }}" @selected($selectedPaymentType === $paymentType->value)>{{ $paymentType->label() }}</option>
                                @endforeach
                            </select>
                        </label>

                        @foreach($paymentTypes as $paymentType)
                            <fieldset class="moreno-payment-method-fields" data-payment-method-fields="{{ $paymentType->value }}" @if($selectedPaymentType !== $paymentType->value) hidden disabled @endif>
                                @foreach($paymentType->fields() as $fieldName => $field)
                                    <label class="moreno-payment-field">
                                        <span>{{ $field['label'] }}</span>
                                        <input
                                            type="{{ $fieldName === 'email' ? 'email' : 'text' }}"
                                            name="{{ $fieldName }}"
                                            value="{{ $selectedPaymentType === $paymentType->value ? old($fieldName) : '' }}"
                                            placeholder="{{ $field['placeholder'] }}"
                                            autocomplete="off"
                                            @if(in_array('required', $field['rules'], true)) required @endif
                                        >
                                    </label>
                                @endforeach
                            </fieldset>
                        @endforeach

                        @if($paymentMethods->isNotEmpty())
                            <label class="moreno-payment-default">
                                <input type="checkbox" name="is_default" value="1" @checked(old('is_default'))>
                                <span>Usarlo como método predeterminado</span>
                            </label>
                        @endif

                        <button type="submit" class="moreno-dashboard-action">Guardar método</button>
                    </form>
                </details>
            @endif
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

@push('scripts')
    <script>
        document.querySelectorAll('[data-payment-method-form]').forEach(function (form) {
            var typeSelect = form.querySelector('[data-payment-method-type]');

            function showFieldsFor(type) {
                form.querySelectorAll('[data-payment-method-fields]').forEach(function (fieldset) {
                    var isActive = fieldset.dataset.paymentMethodFields === type;
                    fieldset.hidden = !isActive;
                    fieldset.disabled = !isActive;
                });
            }

            typeSelect.addEventListener('change', function () {
                showFieldsFor(typeSelect.value);
            });
        });
    </script>
@endpush
