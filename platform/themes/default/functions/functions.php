<?php

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\DashboardMenuItem;
use Botble\Media\Facades\RvMedia;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;
use Botble\Theme\Typography\TypographyItem;
use Botble\Widget\Events\RenderingWidgetSettings;
register_page_template([
    'default' => __('Default'),
    'homepage' => __('Home Page'),
]);

app()->booted(function () {
    RvMedia::addSize('medium', 800, 800);

    ThemeSupport::registerSiteCopyright();

    Theme::typography()
        ->registerFontFamilies([
            new TypographyItem('primary', __('Primary'), 'Roboto'),
        ])
        ->registerFontSizes([
            new TypographyItem('h1', __('Heading 1'), 28),
            new TypographyItem('h2', __('Heading 2'), 24),
            new TypographyItem('h3', __('Heading 3'), 22),
            new TypographyItem('h4', __('Heading 4'), 20),
            new TypographyItem('h5', __('Heading 5'), 18),
            new TypographyItem('h6', __('Heading 6'), 16),
            new TypographyItem('body', __('Body'), 14),
        ]);

        ThemeSupport::registerSocialLinks();
        ThemeSupport::registerToastNotification();
        ThemeSupport::registerPreloader();
        ThemeSupport::registerSiteCopyright();
        ThemeSupport::registerDateFormatOption();
        ThemeSupport::registerLazyLoadImages();
        ThemeSupport::registerSocialSharing();
        ThemeSupport::registerSiteLogoHeight();

        register_page_template([
            'no-sidebar' => __('No sidebar'),
        ]);

        app('events')->listen(RenderingWidgetSettings::class, function (): void {
            register_sidebar([
                'id'          => 'footer_widgets',
                'name'        => __('Footer Widgets'),
                'description' => __('All widgets related to footer'),
            ]);
            remove_sidebar('primary_sidebar');
        });

        add_filter(DASHBOARD_FILTER_ADMIN_LIST, function ($widgets, $widgetSettings) {
            if(!is_plugin_active('domain')) return $widgets;

            return (new \Botble\Dashboard\Supports\DashboardWidgetInstance)
                ->setType('stats')
                ->setPermission('the permission key to check')
                ->setKey('widget_total_domains')
                ->setTitle(__('Domains'))
                ->setIcon('fas fa-edit')
                ->setColor('#9B27B3')
                ->setStatsTotal(\Botble\Domain\Models\Domain::count())
                ->setRoute(route('domain.index'))
                ->init($widgets, $widgetSettings);
        }, 1221, 2);
        add_filter(DASHBOARD_FILTER_ADMIN_LIST, function ($widgets, $widgetSettings) {
            if(!is_plugin_active('brands')) return $widgets;

            return (new \Botble\Dashboard\Supports\DashboardWidgetInstance)
                ->setType('stats')
                ->setPermission('the permission key to check')
                ->setKey('widget_total_brands')
                ->setTitle(__('Brands'))
                ->setIcon('fas fa-edit')
                ->setColor('#192433')
                ->setStatsTotal(\Botble\Brands\Models\Brands::count())
                ->setRoute(route('brands.index'))
                ->init($widgets, $widgetSettings);
        }, 1222, 2);
        add_filter(DASHBOARD_FILTER_ADMIN_LIST, function ($widgets) {
            \Illuminate\Support\Arr::forget($widgets, 'widget_total_themes');
            \Illuminate\Support\Arr::forget($widgets, 'widget_total_plugins');

            return $widgets;
        }, 120, 1);

    \Illuminate\Support\Facades\Event::listen(\Illuminate\Routing\Events\RouteMatched::class, function () {
        if(str_starts_with(request()->getRequestUri(),'/account') )
        {
            dashboard_menu()
                ->for('member')
                ->removeItem('cms-member-posts');

            if (in_array(\Illuminate\Support\Facades\Route::currentRouteName(), ['public.member.posts.index', 'public.member.posts.create'])) {
                abort(403);
            }
        }
    });
});
