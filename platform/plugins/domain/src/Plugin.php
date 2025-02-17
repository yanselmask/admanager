<?php

namespace Botble\Domain;

use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('Domains');
        Schema::dropIfExists('Domains_translations');
    }
}
