<?php

namespace Botble\Brands;

use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('Brands');
        Schema::dropIfExists('Brands_translations');
    }
}
