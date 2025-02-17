<?php

use Botble\Shortcode\View\View;
use Botble\Theme\Theme;

return [

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these events can be overridden by package config.
    |
    */

    'events' => [

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb templates or anything
        // you want inheriting.
        'before' => function ($theme): void {
            // You can remove this line anytime.
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb templates.
        'beforeRenderTheme' => function (Theme $theme): void {
            // Partial composer.
            // $theme->partialComposer('header', function($view) {
            //     $view->with('auth', \Auth::user());
            // });

            // You may use this event to set up your assets.

            $version = get_cms_version();

            $theme->asset()->usePath()->add('bootstrapcss', 'vendors/bootstrap/css/bootstrap.min.css', version: $version);
            $theme->asset()->usePath()->add('font-awesome', 'css/font-awesome.min.css', version: $version);
            $theme->asset()->usePath()->add('themify-icon', 'vendors/themify-icon/themify-icons.css', version: $version);
            $theme->asset()->usePath()->add('icomoon', 'vendors/icomoon/style.css', version: $version);
            $theme->asset()->usePath()->add('slick', 'vendors/slick/slick.css', version: $version);
            $theme->asset()->usePath()->add('slick-theme', 'vendors/slick/slick-theme.css', version: $version);
            $theme->asset()->usePath()->add('animationcss', 'vendors/animation/animate.css', version: $version);
            $theme->asset()->usePath()->add('magnify-pop', 'vendors/magnify-pop/magnific-popup.css', version: $version);
            $theme->asset()->usePath()->add('style', 'css/style.css', version: $version);
            $theme->asset()->usePath()->add('vendors/bootstrap/css/bootstrap.min.css', 'css/responsive.css', version: $version);

            $theme->asset()->container('footer')->usePath()->add('jquery', 'libraries/jquery.min.js');

            $theme->asset()->container('footer')->usePath()->add(
                'popper',
                'vendors/bootstrap/js/popper.min.js',
                ['jquery'],
                version: $version
            );
            $theme->asset()->container('footer')->usePath()->add(
                'bootstrapjs',
                'vendors/bootstrap/js/bootstrap.min.js',
                ['jquery'],
                version: $version
            );
            $theme->asset()->container('footer')->usePath()->add(
                'slickjs',
                'vendors/slick/slick.min.js',
                ['jquery'],
                version: $version
            );
            $theme->asset()->container('footer')->usePath()->add(
                'parallaxjs',
                'vendors/parallax/jquery.parallax-scroll.js',
                ['jquery'],
                version: $version
            );
            $theme->asset()->container('footer')->usePath()->add(
                'wowjs',
                'vendors/wow/wow.min.js',
                ['jquery'],
                version: $version
            );
            $theme->asset()->container('footer')->usePath()->add(
                'gsapjs',
                'js/gsap.min.js',
                ['jquery'],
                version: $version
            );
            $theme->asset()->container('footer')->usePath()->add(
                'SplitTextjs',
                'js/SplitText.js',
                ['jquery'],
                version: $version
            );
            $theme->asset()->container('footer')->usePath()->add(
                'ScrollTriggerjs',
                'js/ScrollTrigger.min.js',
                ['jquery'],
                version: $version
            );
            $theme->asset()->container('footer')->usePath()->add(
                'SmoothScrolljs',
                'js/SmoothScroll.js',
                ['jquery'],
                version: $version
            );
            $theme->asset()->container('footer')->usePath()->add(
                'agnify-pop-js',
                'vendors/magnify-pop/jquery.magnific-popup.min.js',
                ['jquery'],
                version: $version
            );
            $theme->asset()->container('footer')->usePath()->add(
                'customjs',
                'js/custom.js',
                ['jquery'],
                version: $version
            );

            $theme->addBodyAttributes([
                'data-scroll-animation' => 'true'
            ]);

            if (function_exists('shortcode')) {
                $theme->composer(['page'], function (View $view) {
                    $view->withShortcodes();
                });
            }
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => [
            'default' => function ($theme): void {
                // $theme->asset()->usePath()->add('ipad', 'css/layouts/ipad.css');
            },
        ],
    ],
];
