
<!-- Contenido principal -->
<!-- ===============================================--><!--    Main Content--><!-- ===============================================-->
<main class="main" id="top">
    <div class="container" data-layout="container">
        @include('plugins/member::themes.dashboard.layouts.navs')
        <div class="content">
            @include('plugins/member::themes.dashboard.layouts.sidebar')
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
<!-- ===============================================--><!--    End of Main Content--><!-- ===============================================-->
