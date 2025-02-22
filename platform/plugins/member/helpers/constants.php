<?php

if (! defined('MEMBER_MODULE_SCREEN_NAME')) {
    define('MEMBER_MODULE_SCREEN_NAME', 'member');
}

if (! defined('MEMBER_TOP_MENU_FILTER')) {
    define('MEMBER_TOP_MENU_FILTER', 'member-top-menu');
}

if (! defined('MEMBER_TOP_STATISTIC_FILTER')) {
    define('MEMBER_TOP_STATISTIC_FILTER', 'member-top-statistic');
}

if(!function_exists('generate_invoice'))
{
    function generate_invoice()
    {
        $prefix = setting('invoice_prefix', 'INV');
        $invoiceNumber = (\Botble\Member\Models\Invoice::latest()->first()?->id ?? 0 ) + 1;

        return $prefix . str_pad($invoiceNumber, 6, "0", STR_PAD_LEFT);

    }
}

if(!function_exists('currencies_codes'))
{
    function currencies_codes()
    {
        $currenciesRaw = json_decode(setting('invoices_currencies', '[]'), true);

        return Arr::mapWithKeys($currenciesRaw, function ($items) {
            $formatted = [];

            foreach ($items as $item) {
                $formatted[$item['key']] = $item['value'];
            }

            return [$formatted['code'] => $formatted['name']];
        });
    }
}

if(!function_exists('get_currency_code'))
{
    function get_currency_code($code = null)
    {
        $currenciesRaw = json_decode(setting('invoices_currencies', '[]'), true);

        $all = Arr::mapWithKeys($currenciesRaw, function ($items) {
            $formatted = [];

            foreach ($items as $item) {
                $formatted[$item['key']] = $item['value'];
            }

            return [$formatted['code'] => [
                'code' => $formatted['code'],
                'name' => $formatted['name'],
                'symbol' => $formatted['symbol'],
            ]];
        });

        if($code)
        {
            return $all[$code];
        }

        return $all;
    }
}



