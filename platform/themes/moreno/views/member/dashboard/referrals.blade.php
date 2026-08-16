@extends('theme.moreno::views.member.dashboard.layouts.master')

@section('content')
    {!! apply_filters(MEMBER_TOP_STATISTIC_FILTER, null) !!}

    @php
        $referralLink = route('public.member.register') . '?ref_by=' . $user->username;
        $balance = (float) MetaBox::getMetaData($user, 'balances', true);
    @endphp

    <div class="moreno-dashboard-empty moreno-referrals-page">
        <section class="moreno-referrals-hero">
            <div class="moreno-referrals-hero-copy">
                <span class="moreno-dashboard-kicker">Tu red de crecimiento</span>
                <h1>Invita a tu red y crezcan juntos</h1>
                <p>Comparte tu enlace personal. Cada nuevo creador que se registre desde tu invitación aparecerá aquí.</p>
            </div>
            <div class="moreno-referrals-hero-mark" aria-hidden="true">
                <span class="fas fa-users"></span>
            </div>
        </section>

        <section class="moreno-referrals-share" aria-labelledby="moreno-referral-link-title">
            <div>
                <span class="moreno-referrals-section-label" id="moreno-referral-link-title">Tu enlace de invitación</span>
                <p>Listo para compartir con tu comunidad.</p>
            </div>
            <div class="moreno-referrals-link-control">
                <input type="text" value="{{ $referralLink }}" readonly aria-label="Enlace de invitación" data-referral-link>
                <button type="button" class="moreno-referrals-copy" data-copy-referral>
                    <span class="fas fa-copy" aria-hidden="true"></span>
                    <span>Copiar enlace</span>
                </button>
            </div>
            <span class="moreno-referrals-copy-status" data-copy-status role="status" aria-live="polite">
                <span class="fas fa-check" aria-hidden="true"></span>
                <span>Enlace copiado</span>
            </span>
        </section>

        <div class="moreno-referrals-metrics" aria-label="Resumen de referidos">
            <article class="moreno-referrals-metric">
                <span class="moreno-referrals-metric-icon"><span class="fas fa-user-plus" aria-hidden="true"></span></span>
                <div>
                    <span>Referidos activos</span>
                    <strong>{{ $referrals->total() }}</strong>
                </div>
            </article>
            <article class="moreno-referrals-metric">
                <span class="moreno-referrals-metric-icon"><span class="fas fa-wallet" aria-hidden="true"></span></span>
                <div>
                    <span>Balance generado</span>
                    <strong>${{ number_format($balance, 2) }}</strong>
                </div>
            </article>
        </div>

        <section class="moreno-referrals-list" aria-labelledby="moreno-referrals-list-title">
            <div class="moreno-referrals-list-heading">
                <div>
                    <span class="moreno-referrals-section-label">Actividad de tu red</span>
                    <h2 id="moreno-referrals-list-title">Tus referidos</h2>
                </div>
                <span class="moreno-referrals-count">{{ $referrals->total() }} {{ $referrals->total() === 1 ? 'persona' : 'personas' }}</span>
            </div>

            @forelse($referrals as $ref)
                @php
                    $referralBalance = (float) MetaBox::getMetaData($ref, 'balances', true);
                @endphp
                <article class="moreno-referral-row">
                    <span class="moreno-referral-avatar" aria-hidden="true">
                        {{ mb_strtoupper(mb_substr($ref->first_name ?: $ref->username, 0, 1)) }}
                    </span>
                    <div class="moreno-referral-person">
                        <strong>{{ $ref->name }}</strong>
                        <span>{{ '@' . $ref->username }}</span>
                    </div>
                    <div class="moreno-referral-status"><span></span>Activo</div>
                    <div class="moreno-referral-balance">
                        <span>Balance</span>
                        <strong>${{ number_format($referralBalance, 2) }}</strong>
                    </div>
                </article>
            @empty
                <div class="moreno-referrals-empty-state">
                    <span class="moreno-referrals-empty-icon" aria-hidden="true"><span class="fas fa-user-plus"></span></span>
                    <h3>Aún no tienes referidos</h3>
                    <p>Comparte tu enlace para invitar a tu primer creador y empieza a construir tu red.</p>
                    <button type="button" class="moreno-dashboard-action" data-copy-referral>
                        Compartir mi enlace <span aria-hidden="true">&rarr;</span>
                    </button>
                </div>
            @endforelse

            @if($referrals->hasPages())
                <div class="moreno-referrals-pagination">
                    {{ $referrals->links() }}
                </div>
            @endif
        </section>
    </div>
@stop

@push('scripts')
    <script>
        (() => {
            const linkInput = document.querySelector('[data-referral-link]');
            const copyButtons = document.querySelectorAll('[data-copy-referral]');
            const status = document.querySelector('[data-copy-status]');

            if (!linkInput || !copyButtons.length) {
                return;
            }

            let statusTimeout;

            const showCopiedState = () => {
                if (status) {
                    status.classList.add('is-visible');
                }

                window.clearTimeout(statusTimeout);
                statusTimeout = window.setTimeout(() => {
                    if (status) {
                        status.classList.remove('is-visible');
                    }
                }, 2400);
            };

            const copyReferral = async () => {
                try {
                    await navigator.clipboard.writeText(linkInput.value);
                } catch (error) {
                    linkInput.select();
                    linkInput.setSelectionRange(0, 99999);
                    document.execCommand('copy');
                }

                showCopiedState();
            };

            copyButtons.forEach((button) => button.addEventListener('click', copyReferral));
        })();
    </script>
@endpush
