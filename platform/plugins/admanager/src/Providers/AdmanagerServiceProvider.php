<?php

namespace Botble\Admanager\Providers;

use Botble\Base\Facades\PanelSectionManager;
use Botble\Base\PanelSections\PanelSectionItem;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Facades\DashboardMenu;
use Botble\Admanager\Models\Admanager;
use Botble\Setting\PanelSections\SettingOthersPanelSection;

class AdmanagerServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/admanager')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadRoutes();

            if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
                \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(Admanager::class, [
                    'name',
                ]);
            }

        PanelSectionManager::default()->beforeRendering(function (): void {
            PanelSectionManager::registerItem(
                SettingOthersPanelSection::class,
                fn () => PanelSectionItem::make('admanager')
                    ->setTitle(trans('Google Ad Manager'))
                    ->withIcon('ti ti-credit-card')
                    ->withPriority(170)
                    ->withDescription(trans('Configure your Google Ad Manager'))
                    ->withRoute('admanager.settings')
            );
        });
    }
}
