@props([
    'fixed' => false
])
<!DOCTYPE html>
<html {!! Theme::htmlAttributes() !!}>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>

        <style>
            :root {
                --primary-color: {{ theme_option('primary_color', '#ff2b4a') }};
            }
        </style>

        {!! Theme::header() !!}
    </head>
    <body {!! Theme::bodyAttributes() !!}>
        {!! apply_filters(THEME_FRONT_BODY, null) !!}
        <div class="body_wrapper">
            <!-- Preloader Start -->
            @if(theme_option('preloader_swift'))
                @php
                    $siteNameToArray = str_split(theme_option('site_title'));
                @endphp
            <div id="preloader" class="preloader">
                <div class="animation-preloader">
                    <div class="spinner">
                    </div>
                    <div class="txt-loading">
                        @foreach($siteNameToArray as $letter)
                            <span data-text-preloader="P" class="letters-loading">
                                {{$letter}}
                            </span>
                        @endforeach
                    </div>
                    <p class="text-center">{{__('Loading')}}</p>
                </div>
                <div class="loader">
                    <div class="row">
                        <div class="col-3 loader-section section-left">
                            <div class="bg"></div>
                        </div>
                        <div class="col-3 loader-section section-left">
                            <div class="bg"></div>
                        </div>
                        <div class="col-3 loader-section section-right">
                            <div class="bg"></div>
                        </div>
                        <div class="col-3 loader-section section-right">
                            <div class="bg"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- start header  -->
            <nav class="navbar navbar-expand-lg sticky_nav">
                <div class="container">
                    <a class="navbar-brand" href="{{ BaseHelper::getHomepageUrl() }}">
                        {{ Theme::getLogoImage(maxHeight: 50) }}
                    </a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        {!!
                            Menu::renderMenuLocation('main-menu', [
                                'options' => ['class' => 'navbar-nav menu me-lg-auto ms-lg-auto'],
                                'view'    => 'main-menu',
                            ])
                        !!}
                        {!! Theme::partial('header-buttons') !!}
                    </div>
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu_toggle">
                        <span class="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                        <span class="hamburger-cross">
                            <span></span>
                            <span></span>
                        </span>
                    </span>
                    </button>
                </div>
            </nav>
            <!-- End header  -->
