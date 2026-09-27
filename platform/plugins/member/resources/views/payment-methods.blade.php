@if ($paymentMethods->isEmpty())
    <p class="text-muted mb-0">Este miembro aún no ha registrado métodos de pago.</p>
@else
    <div class="d-flex flex-column gap-3">
        @foreach ($paymentMethods as $paymentMethod)
            <div @class(['border rounded p-3', 'border-primary' => $paymentMethod->is_default])>
                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                    <strong>
                        <i class="{{ $paymentMethod->type->icon() }} me-1"></i>
                        {{ $paymentMethod->type->label() }}
                    </strong>
                    @if ($paymentMethod->is_default)
                        <span class="badge bg-primary text-primary-fg">Predeterminado</span>
                    @endif
                </div>

                <x-core::datagrid>
                    @foreach ($paymentMethod->type->fields() as $fieldName => $field)
                        @continue(blank($paymentMethod->details[$fieldName] ?? null))
                        <x-core::datagrid.item>
                            <x-slot:title>{{ $field['label'] }}</x-slot:title>
                            <span class="user-select-all text-break">{{ $paymentMethod->details[$fieldName] }}</span>
                        </x-core::datagrid.item>
                    @endforeach
                </x-core::datagrid>

                <small class="text-muted d-block mt-2">Agregado el {{ $paymentMethod->created_at->translatedFormat('d M Y') }}</small>
            </div>
        @endforeach
    </div>
@endif
