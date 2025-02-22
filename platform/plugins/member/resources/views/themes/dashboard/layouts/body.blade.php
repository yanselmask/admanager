<header class="header--mobile">
    <div class="header__left">
        <button class="navbar-toggler">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="header__center">
        <a class="ps-logo" href="{{ route('public.member.dashboard') }}">
            {!! Theme::getLogoImage(maxHeight: 40) !!}
        </a>
    </div>
    <div class="header__right">
        <a href="{{ route('public.member.logout') }}">
            <x-core::icon name="ti ti-logout" />
        </a>
    </div>
</header>
<aside class="ps-drawer--mobile">
    <div class="ps-drawer__header py-3">
        <h4 class="fs-3 mb-0">Menu</h4>
        <button class="ps-drawer__close">
            <x-core::icon name="ti ti-x" />
        </button>
    </div>
    <div class="ps-drawer__content">
        @include('plugins/member::themes.dashboard.layouts.menu')
    </div>
</aside>

<div class="ps-site-overlay"></div>

<main class="ps-main">
    <div class="ps-main__sidebar">
        <div class="ps-sidebar">
            <div class="ps-sidebar__top">
                <div class="ps-block--user-wellcome">
                    <div class="ps-block__left">
                        <img
                            src="{{ auth('member')->user()->avatar_url }}"
                            alt="{{ auth('member')->user()->name }}"
                            class="avatar avatar-lg"
                        />
                    </div>
                    <div class="ps-block__right">
                        <p>{{ __('Hello') }}, {{ auth('member')->user()->name }}</p>
                        <small>{{ __('Joined on :date', ['date' => auth('member')->user()->created_at->translatedFormat('M d, Y')]) }}</small>
                    </div>
                    <div class="ps-block__action">
                        <a href="{{ route('public.member.logout') }}">
                            <x-core::icon name="ti ti-logout" />
                        </a>
                    </div>
                </div>

                @if(setting('member_kyc_is_required', false))
                <div class="ps-block--earning-count">
                    <small>{{ __('Kyc verified') }}</small> <br />
                   <div class="badge text-white bg-{{auth('member')->user()->kyc?->status?->getValue() == 'published' ? 'success' : 'danger'}}">{{auth('member')->user()->kyc?->status?->getValue() == 'published' ? __('Yes') : __('No')}}</div>
                </div>
                @endif
            </div>
            <div class="ps-sidebar__content">
                <div class="ps-sidebar__center">
                    @include('plugins/member::themes.dashboard.layouts.menu')
                </div>
                <div class="ps-sidebar__footer">
                    <div class="ps-copyright">
                        <a href="{{ BaseHelper::getHomepageUrl() }}" title="{{ $siteTitle = theme_option('site_title') }}">
                            {!! Theme::getLogoImage(maxHeight: 40) !!}
                        </a>

                        @if ($copyright = Theme::getSiteCopyright())
                            <p>{!! $copyright !!}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        class="ps-main__wrapper"
        id="vendor-dashboard"
    >
        <header class="d-sm-flex justify-content-between align-items-center mb-3">
            <h3 class="fs-1">{{ PageTitle::getTitle(false) }}</h3>

            <div class="d-flex align-items-center gap-4">
                @if (is_plugin_active('language'))
                    @include('plugins/member::themes.dashboard.layouts.language-switcher')
                @endif

                <a href="{{ BaseHelper::getHomepageUrl() }}" target="_blank" class="d-flex align-items-center gap-2 text-uppercase">
                    {{ __('Go to homepage') }}
                    <x-core::icon name="ti ti-arrow-right" />
                </a>
            </div>
        </header>

        <div id="app">
            @yield('content')
        </div>
    </div>
</main>
