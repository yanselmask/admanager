<?php

namespace Botble\Admanager;

use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('Admanagers');
        Schema::dropIfExists('Admanagers_translations');
    }
}
