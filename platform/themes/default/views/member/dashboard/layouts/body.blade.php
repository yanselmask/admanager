@php($dashboardNs = Theme::getThemeNamespace('views.member.dashboard'))

<!-- Contenido principal -->
<main class="main" id="top">
    <div class="container" data-layout="container">
        @include($dashboardNs . '.layouts.navs')
        <div class="content">
            @include($dashboardNs . '.layouts.sidebar')
            @yield('content')

            <footer class="footer">
                <div class="row g-0 justify-content-between fs-10 mt-4 mb-3">
                    <div class="col-12 col-sm-auto text-center">
                        <p class="mb-0 text-600">{!! Theme::getSiteCopyright() !!}</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</main>
