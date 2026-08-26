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
    </head>
    <body {!! Theme::bodyAttributes() !!} >
        <header class="fixed top-0 w-full z-50 bg-[#0a0f1c]/80 backdrop-blur border-b border-cyan-400/20">
         <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <a href="{{route('public.index')}}">
                        @if(theme_option('logo'))
                        <img src="{{RvMedia::url(theme_option('logo'))}}" style="height: 2rem" alt="Logo">
                        @else
                        <div class="text-2xl font-bold bg-gradient-to-tr from-cyan-500 to-cyan-400 bg-clip-text text-transparent">AM</div>
                        <div class="font-semibold text-lg">AMAURI MATOM</div>
                        <div class="text-xs text-slate-400 -mt-1">NETWORK</div>
                        @endif
                    </a>
                </div>
                <!-- Nav -->
                {!!
                    Menu::renderMenuLocation('main-menu', [
                        'options' => [ 'class' => 'hidden md:flex gap-8 font-medium' ],
                        'theme' => true,
                        'view' => 'custom-menu',
                    ])
                !!}
                <a href="{{route('public.member.dashboard')}}" class="hidden md:inline-flex bg-gradient-to-tr from-cyan-500 to-cyan-400 text-white font-semibold px-6 py-2 rounded-lg shadow transition hover:-translate-y-1 hover:shadow-cyan-500/30">{{auth('member')->check() ? 'Panel de control' : 'Únete Ahora'}}</a>
                <!-- Mobile -->
                <button id="menu-btn" class="md:hidden text-2xl focus:outline-none">☰</button>
            </div>
            <!-- Mobile Nav -->
             {!!
                    Menu::renderMenuLocation('main-menu', [
                        'options' => ['class' => 'md:hidden hidden text-slate-400 space-y-2 mb-3', 'id' => 'mobile-nav'],
                        'theme' => true,
                        'view' => 'custom-menu-mobile',
                    ])
                !!}
            </div>
        </header>
        {!! apply_filters(THEME_FRONT_BODY, null) !!}
