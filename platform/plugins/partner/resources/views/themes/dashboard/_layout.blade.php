<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ PageTitle::getTitle(false) }}</title>
    <style>
        :root { color-scheme: light dark; }
        body { margin: 0; font: 15px/1.5 system-ui, -apple-system, "Segoe UI", sans-serif; background: #0f1115; color: #e6e8eb; }
        .wrap { max-width: 1100px; margin: 0 auto; padding: 24px 20px 64px; }
        header.bar { display: flex; flex-wrap: wrap; gap: 12px; align-items: baseline; justify-content: space-between; margin-bottom: 20px; }
        h1 { font-size: 20px; margin: 0; }
        nav.tabs { display: flex; gap: 4px; margin-bottom: 20px; flex-wrap: wrap; }
        nav.tabs a { padding: 7px 14px; border-radius: 8px; text-decoration: none; color: #a8b0bb; background: #191d24; }
        nav.tabs a.active { background: #2879d2; color: #fff; }
        .periods { display: flex; gap: 4px; flex-wrap: wrap; margin-bottom: 20px; }
        .periods a { padding: 5px 11px; border-radius: 999px; font-size: 13px; text-decoration: none; color: #a8b0bb; background: #191d24; }
        .periods a.active { background: #2879d2; color: #fff; }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 14px; margin-bottom: 26px; }
        .card { background: #191d24; border-radius: 12px; padding: 18px; }
        .card .label { font-size: 12px; text-transform: uppercase; letter-spacing: .05em; color: #8b95a3; }
        .card .value { font-size: 26px; font-weight: 600; margin-top: 6px; }
        table { width: 100%; border-collapse: collapse; background: #191d24; border-radius: 12px; overflow: hidden; }
        th, td { padding: 11px 14px; text-align: left; border-bottom: 1px solid #232830; font-size: 14px; }
        th { font-size: 12px; text-transform: uppercase; letter-spacing: .05em; color: #8b95a3; }
        tr:last-child td { border-bottom: 0; }
        td.num, th.num { text-align: right; font-variant-numeric: tabular-nums; }
        .empty { background: #191d24; border-radius: 12px; padding: 40px 24px; text-align: center; color: #a8b0bb; }
        .pagination { margin-top: 18px; }
        .pagination a, .pagination span { color: #a8b0bb; padding: 4px 8px; }
    </style>
</head>
<body>
<div class="wrap">
    <header class="bar">
        <h1>{{ PageTitle::getTitle(false) }}</h1>
        <span>{{ $partner->name }}</span>
    </header>

    <nav class="tabs">
        <a href="{{ route('partner.dashboard', ['period' => $period]) }}" class="{{ request()->routeIs('partner.dashboard') ? 'active' : '' }}">{{ trans('plugins/partner::partner.dashboard.title') }}</a>
        <a href="{{ route('partner.accounts', ['period' => $period]) }}" class="{{ request()->routeIs('partner.accounts') ? 'active' : '' }}">{{ trans('plugins/partner::partner.dashboard.accounts') }}</a>
        <a href="{{ route('partner.domains', ['period' => $period]) }}" class="{{ request()->routeIs('partner.domains') ? 'active' : '' }}">{{ trans('plugins/partner::partner.dashboard.domains') }}</a>
        <a href="{{ route('public.member.settings') }}">{{ __('Settings') }}</a>
        <a href="{{ route('public.member.logout') }}">{{ __('Logout') }}</a>
    </nav>

    <div class="periods">
        @foreach($periods as $key)
            <a href="{{ request()->fullUrlWithQuery(['period' => $key]) }}" class="{{ $period === $key ? 'active' : '' }}">
                {{ trans('plugins/partner::partner.periods.' . $key) }}
            </a>
        @endforeach
    </div>

    @yield('content')
</div>
</body>
</html>
