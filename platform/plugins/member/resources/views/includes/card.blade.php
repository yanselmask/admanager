@php
    $col        = $col ?? 'col-6 col-md-4';
    $extraClass = $extraClass ?? '';
    $icon       = $icon ?? null;
    $label      = $label ?? null;
    $value      = $value ?? null;
    $value2     = $value2 ?? null;
    $value3     = $value3 ?? null;
    $gradient   = $gradient ?? 'linear-gradient(135deg, #1a55a8 0%, #2a7ae4 100%)';
    $shadow     = $shadow ?? 'rgba(42,122,228,0.3)';
@endphp

<div class="{{ $col }} {{ $extraClass }}">
    <div class="card h-100 border-0 overflow-hidden"
         style="background: {{ $gradient }}; border-radius:16px; box-shadow: 0 6px 24px {{ $shadow }};">
        <div class="card-body p-4 position-relative">
            @if($value2 || $value3)
                <div class="position-absolute top-0 end-0 me-3 mt-3"
                     style="cursor:pointer; z-index:2;"
                     data-bs-container="body"
                     data-bs-toggle="popover"
                     data-bs-placement="top"
                     data-bs-content="@isset($value2){{ $value2 }}@endisset@isset($value3) · {{ $value3 }}@endisset">
                    <span class="fas fa-info-circle text-white" style="opacity:0.75; font-size:0.9rem;"></span>
                </div>
            @endif

            <div class="d-flex align-items-center gap-3 mb-3">
                @isset($icon)
                    <div style="background:rgba(255,255,255,0.18); border-radius:12px; width:46px; height:46px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <span class="{{ $icon }} text-white" style="font-size:1.1rem;"></span>
                    </div>
                @endisset
                @isset($label)
                    <span class="text-white fw-semibold text-uppercase"
                          style="font-size:0.7rem; letter-spacing:1px; opacity:0.85;">
                        {{ $label }}
                    </span>
                @endisset
            </div>

            @isset($value)
                <h2 class="text-white fw-bold mb-0" style="font-size:2rem; letter-spacing:-0.5px;">
                    {{ $value }}
                </h2>
            @endisset

            @isset($icon)
                <div class="position-absolute" style="bottom:-12px; right:-12px; pointer-events:none;">
                    <span class="{{ $icon }}" style="font-size:7rem; color:rgba(255,255,255,0.07);"></span>
                </div>
            @endisset
        </div>
    </div>
</div>
