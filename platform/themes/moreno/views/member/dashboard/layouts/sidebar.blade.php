<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand moreno-dashboard-topbar" style="display: none;">
    <div class="moreno-topbar-start">
        <button class="btn moreno-sidebar-toggle moreno-topbar-toggle navbar-toggler-humburger-icon navbar-vertical-toggle" type="button" aria-label="Alternar menú lateral" title="Alternar menú lateral"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
    </div>
    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
        <li class="nav-item dropdown"><a class="nav-link moreno-user-menu-toggle" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Abrir menú de usuario">
                <div class="avatar avatar-xl">
                    <img class="rounded-circle" src="{{ auth('member')->user()->avatar_url }}" alt="{{ auth('member')->user()->name }}" />
                </div>
            </a>
            <div class="dropdown-menu dropdown-caret dropdown-menu-end moreno-user-menu" aria-labelledby="navbarDropdownUser">
                <div class="moreno-user-menu-surface">
                    <div class="moreno-user-menu-profile">
                        <span class="moreno-user-menu-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr(auth('member')->user()->name, 0, 1)) }}</span>
                        <div>
                            <strong>{{ auth('member')->user()->name }}</strong>
                            <span>{{ auth('member')->user()->email }}</span>
                        </div>
                    </div>
                    <div class="moreno-user-menu-links">
                        <a class="dropdown-item" href="{{route('public.member.settings')}}">
                            <span>{{__('Settings')}}</span>
                            <span class="moreno-user-menu-arrow" aria-hidden="true">&rarr;</span>
                        </a>
                        <a class="dropdown-item moreno-user-menu-logout" href="{{route('public.member.logout')}}">
                            <span>{{__('Logout')}}</span>
                            <span class="moreno-user-menu-arrow" aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</nav>
<script>
    var navbarPosition = localStorage.getItem('navbarPosition');
    var navbarVertical = document.querySelector('.navbar-vertical');
    var navbarTopVertical = document.querySelector('.content .navbar-top');
    var navbarTop = document.querySelector('[data-layout] .navbar-top:not([data-double-top-nav');
    var navbarDoubleTop = document.querySelector('[data-double-top-nav]');
    var navbarTopCombo = document.querySelector('.content [data-navbar-top="combo"]');

    if (localStorage.getItem('navbarPosition') === 'double-top') {
        document.documentElement.classList.toggle('double-top-nav-layout');
    }

    if (navbarPosition === 'top') {
        navbarTop?.removeAttribute('style');
        navbarTopVertical?.remove(navbarTopVertical);
        navbarVertical?.remove(navbarVertical);
        navbarTopCombo?.remove(navbarTopCombo);
        navbarDoubleTop?.remove(navbarDoubleTop);
    } else if (navbarPosition === 'combo') {
        navbarVertical?.removeAttribute('style');
        navbarTopCombo?.removeAttribute('style');
        navbarTop?.remove(navbarTop);
        navbarTopVertical?.remove(navbarTopVertical);
        navbarDoubleTop?.remove(navbarDoubleTop);
    } else if (navbarPosition === 'double-top') {
        navbarDoubleTop?.removeAttribute('style');
        navbarTopVertical?.remove(navbarTopVertical);
        navbarVertical?.remove(navbarVertical);
        navbarTop?.remove(navbarTop);
        navbarTopCombo?.remove(navbarTopCombo);
    } else {
        navbarVertical?.removeAttribute('style');
        navbarTopVertical?.removeAttribute('style');
        navbarTop?.remove(navbarTop);
        navbarDoubleTop?.remove(navbarDoubleTop);
        navbarTopCombo?.remove(navbarTopCombo);
    }
</script>
