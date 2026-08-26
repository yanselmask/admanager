<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand moreno-dashboard-topbar" style="display: none;">
    <div class="moreno-topbar-start">
        <button class="btn moreno-sidebar-toggle moreno-topbar-toggle navbar-toggler-humburger-icon navbar-vertical-toggle" type="button" aria-label="Abrir menú lateral" aria-controls="navbarVerticalCollapse" aria-expanded="false" title="Alternar menú lateral"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
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
<script>
    (function () {
        var mobileSidebarMedia = window.matchMedia('(max-width: 991.98px)');
        var root = document.documentElement;
        var sidebar = document.querySelector('.moreno-dashboard .navbar-vertical');
        var sidebarToggle = document.querySelector('.moreno-topbar-toggle');
        var sidebarClose = document.querySelector('.moreno-mobile-sidebar-close');
        var sidebarBackdrop = document.querySelector('.moreno-sidebar-backdrop');
        var dashboardContent = document.querySelector('.moreno-dashboard .content');

        if (!sidebar || !sidebarToggle || !sidebarClose || !sidebarBackdrop || !dashboardContent) {
            return;
        }

        function setSidebarOpen(isOpen, restoreFocus) {
            root.classList.toggle('moreno-sidebar-open', isOpen);
            sidebarToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            sidebarToggle.setAttribute('aria-label', isOpen ? 'Cerrar menú lateral' : 'Abrir menú lateral');

            if ('inert' in dashboardContent) {
                dashboardContent.inert = isOpen;
            }

            if (!isOpen && restoreFocus) {
                sidebarToggle.focus();
            }

            sidebar.setAttribute('aria-hidden', isOpen ? 'false' : 'true');

            if (isOpen) {
                window.requestAnimationFrame(function () {
                    sidebarClose.focus();
                });
            }
        }

        function syncSidebarForViewport() {
            if (mobileSidebarMedia.matches) {
                setSidebarOpen(false, false);
                return;
            }

            root.classList.remove('moreno-sidebar-open');
            sidebar.removeAttribute('aria-hidden');
            sidebarToggle.setAttribute('aria-expanded', 'false');
            sidebarToggle.setAttribute('aria-label', 'Alternar menú lateral');

            if ('inert' in dashboardContent) {
                dashboardContent.inert = false;
            }
        }

        document.addEventListener('click', function (event) {
            if (!mobileSidebarMedia.matches) {
                return;
            }

            var toggle = event.target.closest('.moreno-topbar-toggle');

            if (toggle) {
                event.preventDefault();
                event.stopImmediatePropagation();
                setSidebarOpen(!root.classList.contains('moreno-sidebar-open'), false);
                return;
            }

            if (event.target.closest('.moreno-mobile-sidebar-close') || event.target.closest('.moreno-sidebar-backdrop')) {
                event.preventDefault();
                event.stopImmediatePropagation();
                setSidebarOpen(false, true);
                return;
            }

            if (root.classList.contains('moreno-sidebar-open') && event.target.closest('.navbar-vertical a')) {
                setSidebarOpen(false, false);
            }
        }, true);

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && mobileSidebarMedia.matches && root.classList.contains('moreno-sidebar-open')) {
                event.preventDefault();
                setSidebarOpen(false, true);
            }
        });

        if (typeof mobileSidebarMedia.addEventListener === 'function') {
            mobileSidebarMedia.addEventListener('change', syncSidebarForViewport);
        } else {
            mobileSidebarMedia.addListener(syncSidebarForViewport);
        }

        syncSidebarForViewport();
    })();
</script>
