<?php

namespace Botble\Partner\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Facades\PanelSectionManager;
use Botble\Base\PanelSections\PanelSectionItem;
use Botble\Base\Supports\DashboardMenuItem;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Domain\Models\Domain;
use Botble\Member\Models\Member;
use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Partner\Http\Middleware\RedirectIfNotPartner;
use Botble\Partner\Http\Middleware\RedirectPartnerToOwnPanel;
use Botble\Partner\Models\PartnerNetwork;
use Botble\Partner\Supports\PartnerHelper;
use Botble\Setting\PanelSections\SettingOthersPanelSection;

class PartnerServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/partner')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web', 'partner'])
            ->loadMigrations();

        $this->registerMemberRelations();
        $this->registerMemberDefaults();
        $this->registerDashboardMenu();
        $this->registerSettingsPanel();
        $this->registerMiddleware();
        $this->registerPartnerPanelMenu();
    }

    /**
     * Inyecta las relaciones del partner sobre el modelo Member sin modificar
     * el plugin `member`, que es código de Botble adaptado.
     */
    protected function registerMemberRelations(): void
    {
        Member::resolveRelationUsing(
            'partnerNetworks',
            fn (Member $member) => $member->hasMany(PartnerNetwork::class, 'member_id')
        );

        Member::resolveRelationUsing(
            'partnerDomains',
            fn (Member $member) => $member->hasManyThrough(
                Domain::class,
                PartnerNetwork::class,
                'member_id',
                'network_code',
                'id',
                'network_code'
            )
        );
    }

    /**
     * El default `creator` de la columna lo aplica la base de datos, así que un modelo
     * recién creado tendría `role` a null en memoria hasta recargarlo. Lo fijamos en el
     * evento `creating` para que el invariante valga también antes de releer.
     */
    protected function registerMemberDefaults(): void
    {
        Member::creating(function (Member $member): void {
            if (! $member->getAttribute('role')) {
                $member->setAttribute('role', PartnerRoleEnum::CREATOR);
            }
        });
    }

    protected function registerDashboardMenu(): void
    {
        DashboardMenu::default()->beforeRetrieving(function (): void {
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-partner',
                'priority' => 55,
                'parent_id' => null,
                'name' => 'plugins/partner::partner.name',
                'icon' => 'ti ti-briefcase',
                'url' => route('partner.index'),
                'permissions' => ['partner.index'],
            ]);

            DashboardMenu::registerItem([
                'id' => 'cms-plugins-partner-networks',
                'priority' => 10,
                'parent_id' => 'cms-plugins-partner',
                'name' => 'plugins/partner::partner.networks.name',
                'icon' => 'ti ti-plug-connected',
                'url' => route('partner-network.index'),
                'permissions' => ['partner.index'],
            ]);
        });
    }

    protected function registerSettingsPanel(): void
    {
        PanelSectionManager::default()->beforeRendering(function (): void {
            PanelSectionManager::registerItem(
                SettingOthersPanelSection::class,
                fn () => PanelSectionItem::make('partners')
                    ->setTitle(trans('plugins/partner::partner.settings.title'))
                    ->withIcon('ti ti-briefcase')
                    ->withPriority(175)
                    ->withDescription(trans('plugins/partner::partner.settings.description'))
                    ->withRoute('partner.settings')
            );
        });
    }

    /**
     * `partner` protege el panel del partner. `RedirectPartnerToOwnPanel` se empuja al
     * grupo `web` para rescatar al partner del panel de creadores sin modificar el
     * `LoginController` del plugin `member`.
     */
    protected function registerMiddleware(): void
    {
        $router = $this->app['router'];

        $router->aliasMiddleware('partner', RedirectIfNotPartner::class);
        $router->pushMiddlewareToGroup('web', RedirectPartnerToOwnPanel::class);
    }

    /**
     * Menú lateral del panel según el rol. Para un creador no se toca nada, así que su
     * menú queda exactamente igual que antes de instalar el plugin.
     */
    protected function registerPartnerPanelMenu(): void
    {
        DashboardMenu::for('member')->beforeRetrieving(function (): void {
            if (! PartnerHelper::isPartner(auth('member')->user())) {
                return;
            }

            DashboardMenu::make()
                ->removeItem([
                    'cms-member-dashboard',
                    'cms-member-referrals',
                    'cms-member-invoices',
                ])
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-partner-dashboard')
                        ->priority(10)
                        ->name('plugins/partner::partner.dashboard.title')
                        ->url(fn () => route('partner.dashboard'))
                        ->icon('ti ti-chart-bar')
                )
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-partner-accounts')
                        ->priority(20)
                        ->name('plugins/partner::partner.dashboard.accounts')
                        ->url(fn () => route('partner.accounts'))
                        ->icon('ti ti-briefcase')
                )
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-partner-domains')
                        ->priority(30)
                        ->name('plugins/partner::partner.dashboard.domains')
                        ->url(fn () => route('partner.domains'))
                        ->icon('ti ti-world')
                );
        });
    }
}
