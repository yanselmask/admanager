<style>
    @keyframes float-y {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-14px); }
    }
    @keyframes glow-pulse {
        0%, 100% { opacity: 0.25; }
        50% { opacity: 0.55; }
    }
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes draw-chart {
        from { stroke-dashoffset: 600; }
        to   { stroke-dashoffset: 0; }
    }
    .anim-float { animation: float-y 7s ease-in-out infinite; }
    .anim-glow  { animation: glow-pulse 5s ease-in-out infinite; }
    .anim-slide-up { animation: slide-up 0.6s ease-out both; }
    .chart-line    { stroke-dasharray: 600; animation: draw-chart 2.5s ease-out forwards; }

    .grad-text,
    .grad-text-rev {
        color: var(--ms-brand);
    }
    .btn-primary-cta {
        background: var(--ms-brand);
        box-shadow: 0 6px 28px rgba(0,74,173,0.4);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-primary-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 36px rgba(0,74,173,0.5);
    }
    .card-feature {
        background: rgba(13,20,35,0.9);
        border: 1px solid rgba(0,74,173,0.12);
        transition: transform 0.25s, border-color 0.25s, box-shadow 0.25s;
    }
    .card-feature:hover {
        transform: translateY(-4px);
        border-color: rgba(0,74,173,0.35);
        box-shadow: 0 16px 48px rgba(0,74,173,0.1);
    }
    .mockup-card {
        background: rgba(10,16,30,0.95);
        border: 1px solid rgba(0,74,173,0.18);
        box-shadow: 0 32px 80px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.04);
    }
    .payment-row:not(:last-child) {
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .benefit-card {
        background: rgba(13,20,35,0.8);
        border: 1px solid rgba(255,255,255,0.06);
        transition: border-color 0.2s;
    }
    .benefit-card:hover { border-color: rgba(0,74,173,0.25); }
</style>

{{-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════ --}}
<section class="moreno-hero-section relative pt-28 pb-24 overflow-hidden">

    {{-- Background glows --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="anim-glow absolute -top-60 -left-40 w-[600px] h-[600px] rounded-full"
             style="background: radial-gradient(circle, rgba(0,74,173,0.10) 0%, transparent 65%);"></div>
        <div class="anim-glow absolute -bottom-40 -right-40 w-[500px] h-[500px] rounded-full"
             style="background: radial-gradient(circle, rgba(0,74,173,0.07) 0%, transparent 65%); animation-delay: 2.5s;"></div>
        <div class="absolute inset-0"
             style="background: radial-gradient(ellipse at 50% 110%, rgba(0,74,173,0.05) 0%, transparent 55%);"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="grid md:grid-cols-2 gap-16 items-center">

            {{-- Left copy --}}
            <div class="anim-slide-up">
                <div class="inline-flex items-center gap-2 text-cyan-400 text-xs font-semibold px-4 py-2 rounded-full mb-7"
                     style="background: rgba(0,74,173,0.08); border: 1px solid rgba(0,74,173,0.25);">
                    <span class="w-1.5 h-1.5 bg-cyan-400 rounded-full animate-pulse"></span>
                    Red de monetización exclusiva
                </div>

                <h1 class="text-5xl md:text-6xl font-bold leading-[1.08] mb-6 tracking-tight">
                    GENERA
                    <span class="block grad-text">INGRESOS</span>
                    CON TU
                    <span class="grad-text-rev">CONTENIDO</span>
                </h1>

                <p class="text-lg text-slate-400 mb-9 leading-relaxed max-w-md">
                    Únete a la red de monetización digital más avanzada.
                    <span class="text-white font-medium">Sistema exclusivo</span> para creadores con tecnología de vanguardia.
                </p>

                <div class="flex gap-4 mb-12 flex-wrap">
                    <a href="{{ route('public.member.dashboard') }}"
                       class="btn-primary-cta px-7 py-3.5 rounded-xl font-bold text-white text-base">
                        <span>Comenzar Ahora</span>
                        <span class="moreno-button-arrow" aria-hidden="true">&rarr;</span>
                    </a>
                    <a href="#sistema"
                       class="moreno-secondary-cta px-7 py-3.5 rounded-xl font-semibold border transition-colors duration-200"
                       style="border-color: rgba(0,74,173,0.35);">
                        Ver Demo
                    </a>
                </div>

                <div class="flex items-center gap-8">
                    <div>
                        <div class="text-3xl font-bold grad-text">200+</div>
                        <div class="text-slate-500 text-sm mt-0.5">Creadores activos</div>
                    </div>
                    <div class="w-px h-10 bg-slate-800"></div>
                    <div>
                        <div class="text-3xl font-bold grad-text">$1M+</div>
                        <div class="text-slate-500 text-sm mt-0.5">En pagos realizados</div>
                    </div>
                    <div class="w-px h-10 bg-slate-800"></div>
                    <div>
                        <div class="text-3xl font-bold grad-text">24/7</div>
                        <div class="text-slate-500 text-sm mt-0.5">Soporte dedicado</div>
                    </div>
                </div>
            </div>

            {{-- Right: Dashboard mockup --}}
            <div class="anim-float relative">
                <div class="absolute -inset-6 rounded-3xl anim-glow"
                     style="background: radial-gradient(ellipse, rgba(0,74,173,0.15), transparent 70%);"></div>
                <div class="mockup-card relative rounded-2xl overflow-hidden">
                    {{-- Window chrome --}}
                    <div class="flex items-center justify-between px-5 py-3.5"
                         style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                        <div class="flex gap-1.5">
                            <div class="w-3 h-3 rounded-full" style="background:#ff5f57;"></div>
                            <div class="w-3 h-3 rounded-full" style="background:#febc2e;"></div>
                            <div class="w-3 h-3 rounded-full" style="background:#28c840;"></div>
                        </div>
                        <span class="text-xs text-slate-500 font-medium">Panel de Control</span>
                        <div class="flex items-center gap-1.5 text-green-400 text-xs px-2.5 py-1 rounded-full"
                             style="background: rgba(34,197,94,0.1);">
                            <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                            Live
                        </div>
                    </div>

                    <div class="p-5">
                        {{-- Stat cards --}}
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="moreno-hero-metric-card moreno-hero-metric-card--brand rounded-xl p-4">
                                <div class="text-slate-400 text-xs mb-1.5">Ingresos</div>
                                <div class="text-xl font-bold">$1,200.00</div>
                                <div class="text-green-400 text-xs mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                    </svg>
                                    +15.2%
                                </div>
                            </div>
                            <div class="moreno-hero-metric-card moreno-hero-metric-card--accent rounded-xl p-4">
                                <div class="text-slate-400 text-xs mb-1.5">eCPM</div>
                                <div class="text-xl font-bold">$15.91</div>
                                <div class="text-green-400 text-xs mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                    </svg>
                                    +8.5%
                                </div>
                            </div>
                        </div>

                        {{-- SVG Line chart --}}
                        <div class="moreno-mockup-panel rounded-xl p-4 mb-4">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xs text-slate-400">Evolución de ingresos</span>
                                <span class="text-xs text-cyan-400 px-2 py-0.5 rounded"
                                      style="background:rgba(0,74,173,0.1);">7 días</span>
                            </div>
                            <svg viewBox="0 0 280 72" class="w-full h-14" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="heroChartFill" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%"   stop-color="#004AAD" stop-opacity="0.28"/>
                                        <stop offset="100%" stop-color="#004AAD" stop-opacity="0"/>
                                    </linearGradient>
                                </defs>
                                <path d="M0,66 L40,52 L80,56 L120,34 L160,38 L200,18 L240,22 L280,8"
                                      fill="none" stroke="#004AAD" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round" class="chart-line"/>
                                <path d="M0,66 L40,52 L80,56 L120,34 L160,38 L200,18 L240,22 L280,8 L280,72 L0,72 Z"
                                      fill="url(#heroChartFill)"/>
                                <circle cx="280" cy="8" r="3" fill="#004AAD"/>
                                <circle cx="280" cy="8" r="6" fill="#004AAD" opacity="0.22"/>
                            </svg>
                            <div class="flex justify-between mt-1 text-slate-700 text-xs px-0.5">
                                <span>L</span><span>M</span><span>X</span><span>J</span><span>V</span><span>S</span><span>D</span>
                            </div>
                        </div>

                        {{-- Referrals list --}}
                        <div class="moreno-mockup-panel rounded-xl p-4">
                            <div class="text-xs text-slate-400 mb-3">Referidos activos</div>
                            <div class="flex flex-col gap-2.5">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                             style="background:var(--ms-brand);">J</div>
                                        <span class="text-sm text-slate-300">JulianPQ</span>
                                    </div>
                                    <span class="text-green-400 text-sm font-semibold">$15.00</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                             style="background:var(--ms-brand);">J</div>
                                        <span class="text-sm text-slate-300">Jonathan</span>
                                    </div>
                                    <span class="text-green-400 text-sm font-semibold">$33.00</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                             style="background:var(--ms-brand);">M</div>
                                        <span class="text-sm text-slate-300">Michelle</span>
                                    </div>
                                    <span class="text-green-400 text-sm font-semibold">$59.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     STATS BAR
═══════════════════════════════════════════ --}}
<div class="moreno-stats-band">
    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <div class="text-3xl md:text-4xl font-bold mb-1 grad-text">200+</div>
                <div class="text-slate-500 text-sm">Creadores activos</div>
            </div>
            <div>
                <div class="text-3xl md:text-4xl font-bold mb-1 grad-text">$1M+</div>
                <div class="text-slate-500 text-sm">En pagos realizados</div>
            </div>
            <div>
                <div class="text-3xl md:text-4xl font-bold mb-1 grad-text">98%</div>
                <div class="text-slate-500 text-sm">Tasa de satisfacción</div>
            </div>
            <div>
                <div class="text-3xl md:text-4xl font-bold mb-1 grad-text">24/7</div>
                <div class="text-slate-500 text-sm">Soporte dedicado</div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════
     FEATURES
═══════════════════════════════════════════ --}}
<section id="servicios" class="py-24">
    <div class="max-w-7xl mx-auto px-4">

        <div class="text-center mb-16">
            <p class="text-cyan-400 text-sm font-semibold uppercase tracking-widest mb-3">Por qué elegirnos</p>
            <h2 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                NO ESTARÁS <span class="grad-text">SOLO</span><br>
                ESTARÁS CON LOS <span class="grad-text-rev">MEJORES</span>
            </h2>
            <p class="text-slate-400 text-lg max-w-xl mx-auto">Todo lo que necesitas para monetizar tu contenido y escalar tus ingresos</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">

            <div class="card-feature rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-11 h-11 flex items-center justify-center rounded-xl text-cyan-400 flex-shrink-0"
                         style="background:rgba(0,74,173,0.1);border:1px solid rgba(0,74,173,0.2);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-base mb-1">Sistema Exclusivo</h3>
                        <span class="text-xs text-cyan-400 font-medium px-2.5 py-0.5 rounded-full"
                              style="background:rgba(0,74,173,0.1);">Exclusivo</span>
                    </div>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed">Acceso al sistema más avanzado de monetización con tecnología exclusiva para maximizar tus ingresos.</p>
            </div>

            <div class="card-feature rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-11 h-11 flex items-center justify-center rounded-xl text-cyan-400 flex-shrink-0"
                         style="background:rgba(0,74,173,0.1);border:1px solid rgba(0,74,173,0.2);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-base mb-1">Analytics en Tiempo Real</h3>
                        <span class="text-xs text-cyan-400 font-medium px-2.5 py-0.5 rounded-full"
                              style="background:rgba(0,74,173,0.1);">Tiempo Real</span>
                    </div>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed">Visualiza ganancias, eCPM, estadísticas detalladas y evolución de tu web en tiempo real con dashboards avanzados.</p>
            </div>

            <div class="card-feature rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-11 h-11 flex items-center justify-center rounded-xl text-cyan-400 flex-shrink-0"
                         style="background:rgba(0,74,173,0.1);border:1px solid rgba(0,74,173,0.2);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-base mb-1">Webs Monetizadas</h3>
                        <span class="text-xs text-cyan-400 font-medium px-2.5 py-0.5 rounded-full"
                              style="background:rgba(0,74,173,0.1);">Listo para usar</span>
                    </div>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed">Accede a webs ya monetizadas y listas para generar ingresos. Solo tienes que promocionarlas y ver crecer tus ganancias.</p>
            </div>

            <div class="card-feature rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-11 h-11 flex items-center justify-center rounded-xl text-cyan-400 flex-shrink-0"
                         style="background:rgba(0,74,173,0.1);border:1px solid rgba(0,74,173,0.2);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-base mb-1">Red de Referidos</h3>
                        <span class="text-xs text-cyan-400 font-medium px-2.5 py-0.5 rounded-full"
                              style="background:rgba(0,74,173,0.1);">Ingresos Extra</span>
                    </div>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed">Genera ingresos adicionales refiriendo creadores activos y construye tu red de ganancias pasivas.</p>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     HOW IT WORKS
═══════════════════════════════════════════ --}}
<section id="proceso" class="py-24 moreno-process-section">
    <div class="max-w-7xl mx-auto px-4">

        <div class="text-center mb-16">
            <p class="text-cyan-400 text-sm font-semibold uppercase tracking-widest mb-3">Proceso simple</p>
            <h2 class="text-4xl md:text-5xl font-bold mb-4">
                CÓMO <span class="grad-text">FUNCIONA</span>
            </h2>
            <p class="text-slate-400 text-lg">Empieza a generar ingresos en 3 pasos</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">

            <div class="text-center group">
                <div class="inline-flex items-center justify-content-center w-20 h-20 rounded-2xl mb-6 text-cyan-400 mx-auto"
                     style="background:linear-gradient(135deg,rgba(0,74,173,0.12),rgba(0,74,173,0.04));border:1px solid rgba(0,74,173,0.22);">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <div class="text-xs font-bold text-cyan-400 mb-2 uppercase tracking-widest">Paso 01</div>
                <h3 class="text-xl font-bold mb-3">Regístrate</h3>
                <p class="text-slate-400 leading-relaxed max-w-xs mx-auto">Crea tu cuenta en minutos y accede a nuestro panel de control exclusivo sin complicaciones.</p>
            </div>

            <div class="text-center group">
                <div class="inline-flex items-center justify-content-center w-20 h-20 rounded-2xl mb-6 text-cyan-400 mx-auto"
                     style="background:linear-gradient(135deg,rgba(0,74,173,0.12),rgba(0,74,173,0.04));border:1px solid rgba(0,74,173,0.22);">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                </div>
                <div class="text-xs font-bold text-cyan-400 mb-2 uppercase tracking-widest">Paso 02</div>
                <h3 class="text-xl font-bold mb-3">Conecta tu web</h3>
                <p class="text-slate-400 leading-relaxed max-w-xs mx-auto">Agrega tu dominio o accede a nuestras webs ya monetizadas listas para empezar a generar.</p>
            </div>

            <div class="text-center group">
                <div class="inline-flex items-center justify-content-center w-20 h-20 rounded-2xl mb-6 text-cyan-400 mx-auto"
                     style="background:linear-gradient(135deg,rgba(0,74,173,0.12),rgba(0,74,173,0.04));border:1px solid rgba(0,74,173,0.22);">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-xs font-bold text-cyan-400 mb-2 uppercase tracking-widest">Paso 03</div>
                <h3 class="text-xl font-bold mb-3">Genera ingresos</h3>
                <p class="text-slate-400 leading-relaxed max-w-xs mx-auto">Observa tus ganancias crecer en tiempo real y recibe tus pagos de forma puntual cada mes.</p>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     SYSTEM / DASHBOARD PREVIEW
═══════════════════════════════════════════ --}}
<section id="sistema" class="py-24">
    <div class="max-w-7xl mx-auto px-4">

        <div class="text-center mb-16">
            <p class="text-cyan-400 text-sm font-semibold uppercase tracking-widest mb-3">Panel de control</p>
            <h2 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                VERÁS TUS <span class="grad-text">GANANCIAS</span><br>
                EN <span class="grad-text-rev">TIEMPO REAL</span>
            </h2>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto">
                Podrás ver tus ganancias reales, eCPM, estadísticas detalladas y la evolución de tu web en tiempo real.
                <span class="text-white font-semibold">Todo en un solo panel, claro, preciso y al instante.</span>
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-start">

            {{-- Dashboard UI --}}
            <div class="mockup-card rounded-2xl overflow-hidden">
                <div class="flex items-center justify-between px-5 py-3.5"
                     style="border-bottom:1px solid rgba(255,255,255,0.06);">
                    <div class="flex gap-1.5">
                        <div class="w-3 h-3 rounded-full" style="background:#ff5f57;"></div>
                        <div class="w-3 h-3 rounded-full" style="background:#febc2e;"></div>
                        <div class="w-3 h-3 rounded-full" style="background:#28c840;"></div>
                    </div>
                    <span class="text-xs text-slate-500">Dashboard en Tiempo Real</span>
                    <div class="flex items-center gap-1.5 text-green-400 text-xs px-2.5 py-1 rounded-full"
                         style="background:rgba(34,197,94,0.1);">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                        Live
                    </div>
                </div>
                <div class="p-5">
                    {{-- 4 mini stat cards --}}
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="moreno-metric-card moreno-metric-card--brand rounded-xl p-4">
                            <div class="text-slate-400 text-xs mb-1">Ingresos</div>
                            <div class="text-xl font-bold">$1,200.00</div>
                        </div>
                        <div class="moreno-metric-card moreno-metric-card--blue rounded-xl p-4">
                            <div class="text-slate-400 text-xs mb-1">Impresiones</div>
                            <div class="text-xl font-bold">75,400</div>
                        </div>
                        <div class="moreno-metric-card moreno-metric-card--success rounded-xl p-4">
                            <div class="text-slate-400 text-xs mb-1">Clics</div>
                            <div class="text-xl font-bold">2,360</div>
                        </div>
                        <div class="moreno-metric-card moreno-metric-card--accent rounded-xl p-4">
                            <div class="text-slate-400 text-xs mb-1">eCPM</div>
                            <div class="text-xl font-bold">$15.91</div>
                        </div>
                    </div>

                    {{-- Chart --}}
                    <div class="moreno-mockup-panel rounded-xl p-4 mb-4">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-xs text-slate-400 font-medium">Evolución semanal de ingresos</span>
                            <span class="text-green-400 text-xs font-semibold">+15.2%</span>
                        </div>
                        <svg viewBox="0 0 320 80" class="w-full h-20" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="sysChartFill" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%"   stop-color="#004AAD" stop-opacity="0.22"/>
                                    <stop offset="100%" stop-color="#004AAD" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                            <path d="M0,74 L45,58 L90,63 L135,38 L180,42 L225,20 L270,25 L320,8"
                                  fill="none" stroke="#004AAD" stroke-width="2"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M0,74 L45,58 L90,63 L135,38 L180,42 L225,20 L270,25 L320,8 L320,80 L0,80 Z"
                                  fill="url(#sysChartFill)"/>
                            <circle cx="320" cy="8" r="3.5" fill="#004AAD"/>
                            <circle cx="320" cy="8" r="7"   fill="#004AAD" opacity="0.2"/>
                        </svg>
                        <div class="flex justify-between mt-1 text-slate-700 text-xs">
                            <span>Lun</span><span>Mar</span><span>Mié</span><span>Jue</span><span>Vie</span><span>Sáb</span><span>Dom</span>
                        </div>
                    </div>

                    <div class="flex gap-2 flex-wrap">
                        <span class="px-3 py-1.5 rounded-lg text-xs font-medium text-cyan-400"
                              style="background:rgba(0,74,173,0.1);border:1px solid rgba(0,74,173,0.3);">Gestionar Webs</span>
                        <span class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-400 border border-slate-800">Monetizar Tráfico</span>
                        <span class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-400 border border-slate-800">Red de Referidos</span>
                    </div>
                </div>
            </div>

            {{-- Right column --}}
            <div class="flex flex-col gap-8">

                {{-- Payment history --}}
                <div>
                    <h3 class="text-2xl font-bold mb-3">Historial de Pagos</h3>
                    <p class="text-slate-400 mb-5 leading-relaxed">
                        Desde tu panel verifica fácilmente si tus facturas han sido
                        <span class="text-green-400 font-semibold">PAGADAS</span> o están pendientes,
                        con un historial detallado de todos tus cobros.
                    </p>
                    <div class="moreno-payment-list rounded-xl overflow-hidden">
                        <div class="payment-row flex justify-between items-center px-5 py-4">
                            <div>
                                <div class="font-semibold text-sm">Enero 2025</div>
                                <div class="text-slate-500 text-xs mt-0.5">15 de enero</div>
                            </div>
                            <div class="text-right">
                                <div class="text-green-400 font-bold">$1,450.00</div>
                                <div class="text-green-400 text-xs mt-0.5 flex items-center gap-1 justify-end">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    PAGADO
                                </div>
                            </div>
                        </div>
                        <div class="payment-row flex justify-between items-center px-5 py-4">
                            <div>
                                <div class="font-semibold text-sm">Diciembre 2024</div>
                                <div class="text-slate-500 text-xs mt-0.5">15 de diciembre</div>
                            </div>
                            <div class="text-right">
                                <div class="text-green-400 font-bold">$1,200.00</div>
                                <div class="text-green-400 text-xs mt-0.5 flex items-center gap-1 justify-end">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    PAGADO
                                </div>
                            </div>
                        </div>
                        <div class="payment-row flex justify-between items-center px-5 py-4">
                            <div>
                                <div class="font-semibold text-sm">Noviembre 2024</div>
                                <div class="text-slate-500 text-xs mt-0.5">15 de noviembre</div>
                            </div>
                            <div class="text-right">
                                <div class="text-green-400 font-bold">$980.00</div>
                                <div class="text-green-400 text-xs mt-0.5 flex items-center gap-1 justify-end">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    PAGADO
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Benefits 2x2 --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="benefit-card flex items-start gap-3 p-4 rounded-xl">
                        <div class="text-cyan-400 flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-sm mb-0.5">Ayuda Personalizada</div>
                            <div class="text-slate-500 text-xs">Soporte único para mejorar tu rendimiento</div>
                        </div>
                    </div>
                    <div class="benefit-card flex items-start gap-3 p-4 rounded-xl">
                        <div class="text-cyan-400 flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-sm mb-0.5">Optimizaciones Diarias</div>
                            <div class="text-slate-500 text-xs">Recomendaciones para maximizar ganancias</div>
                        </div>
                    </div>
                    <div class="benefit-card flex items-start gap-3 p-4 rounded-xl">
                        <div class="text-cyan-400 flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-sm mb-0.5">Modificación de Webs</div>
                            <div class="text-slate-500 text-xs">Personaliza según tus necesidades</div>
                        </div>
                    </div>
                    <div class="benefit-card flex items-start gap-3 p-4 rounded-xl">
                        <div class="text-cyan-400 flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-sm mb-0.5">Asistencia 24/7</div>
                            <div class="text-slate-500 text-xs">Te ayudamos a crecer sin límites</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     FINAL CTA
═══════════════════════════════════════════ --}}
<section class="py-28 relative overflow-hidden"
         style="background:linear-gradient(135deg,rgba(0,74,173,0.06) 0%,var(--ms-page) 40%,rgba(0,74,173,0.06) 100%);">
    <div class="absolute inset-0 pointer-events-none">
        <div class="anim-glow absolute inset-0 flex items-center justify-center">
            <div class="w-[700px] h-[350px] rounded-full"
                 style="background:radial-gradient(ellipse,rgba(0,74,173,0.09) 0%,transparent 70%);"></div>
        </div>
    </div>
    <div class="max-w-3xl mx-auto px-4 text-center relative z-10">
        <div class="inline-flex items-center gap-2 text-cyan-400 text-xs font-semibold px-4 py-2 rounded-full mb-7"
             style="background:rgba(0,74,173,0.08);border:1px solid rgba(0,74,173,0.25);">
            <span class="w-1.5 h-1.5 bg-cyan-400 rounded-full animate-pulse"></span>
            Únete a los que ya están ganando de verdad
        </div>
        <h2 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
            ¿Listo para <span class="grad-text">empezar</span><br>
            a generar ingresos?
        </h2>
        <p class="text-slate-400 text-lg mb-10 max-w-xl mx-auto leading-relaxed">
            Escríbenos y comienza hoy mismo. Nuestro equipo está listo para ayudarte a monetizar tu contenido al máximo.
        </p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('public.member.dashboard') }}"
               class="btn-primary-cta px-9 py-4 rounded-xl font-bold text-white text-lg">
                Empezar a Generar Ingresos
            </a>
            <a href="{{ route('public.member.login') }}"
               class="moreno-secondary-cta px-9 py-4 rounded-xl font-bold text-lg border transition-colors duration-200"
               style="border-color:rgba(0,74,173,0.35);">
                Iniciar Sesión
            </a>
        </div>
    </div>
</section>
