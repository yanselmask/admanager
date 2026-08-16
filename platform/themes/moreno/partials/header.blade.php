<!DOCTYPE html>
<html {!! Theme::htmlAttributes() !!}>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>
        <meta name="format-detection" content="telephone=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @if (theme_option('favicon'))
            <link href="{{ RvMedia::getImageUrl(theme_option('favicon')) }}" rel="shortcut icon">
        @endif
        <title>{{ PageTitle::getTitle(false) }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/style.css') }}">
        <script src="{{ Theme::asset()->url('js/script.js') }}" defer></script>
    </head>
    <body {!! Theme::bodyAttributes() !!} >
        <header class="moreno-site-header sticky top-0 w-full z-50 backdrop-blur border-b">
         <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <a href="{{route('public.index')}}">
                        @include('theme.moreno::partials.brand-logo')
                    </a>
                </div>
                <!-- Nav -->
                <nav class="hidden md:flex gap-8 font-medium" aria-label="Navegación principal">
                    <a href="{{ route('public.index') }}#servicios" class="hover:text-cyan-400 transition">Servicios</a>
                    <a href="{{ route('public.index') }}#proceso" class="hover:text-cyan-400 transition">Cómo funciona</a>
                    <a href="{{ route('public.index') }}#sistema" class="hover:text-cyan-400 transition">Plataforma</a>
                </nav>
                <div class="flex items-center gap-3">
                    <button type="button" class="moreno-theme-toggle inline-flex" data-moreno-theme-toggle aria-label="Cambiar de tema">◐</button>
                    <a href="{{route('public.member.dashboard')}}" class="hidden md:inline-flex moreno-cta bg-[#004AAD] text-white font-semibold px-6 py-2 rounded-lg shadow transition hover:-translate-y-1">{{auth('member')->check() ? 'Panel de control' : 'Únete Ahora'}}</a>
                </div>
                <!-- Mobile -->
                <button id="menu-btn" class="md:hidden text-2xl focus:outline-none">☰</button>
            </div>
            <!-- Mobile Nav -->
            <nav class="md:hidden hidden text-slate-400 space-y-2 mb-3" id="mobile-nav" aria-label="Navegación móvil">
                <a href="{{ route('public.index') }}#servicios" class="block hover:text-cyan-400 transition">Servicios</a>
                <a href="{{ route('public.index') }}#proceso" class="block hover:text-cyan-400 transition">Cómo funciona</a>
                <a href="{{ route('public.index') }}#sistema" class="block hover:text-cyan-400 transition">Plataforma</a>
            </nav>
            </div>
        </header>
        {!! apply_filters(THEME_FRONT_BODY, null) !!}
