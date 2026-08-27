<?php

namespace Botble\Partner;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Botble\Setting\Facades\Setting;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('partner_networks');

        if (Schema::hasTable('members')) {
            foreach (['role', 'commission'] as $column) {
                if (Schema::hasColumn('members', $column)) {
                    Schema::table('members', function ($table) use ($column): void {
                        $table->dropColumn($column);
                    });
                }
            }
        }

        Setting::delete([
            'partner_percentage_default',
            'partner_earning_base',
            'earning_partner',
            'clicks_partner',
            'impressions_partner',
            'ctrs_partner',
            'ecpms_partner',
        ]);
    }
}
