<?php

if(!function_exists('getValueWithCommissions'))
{
    function getValueWithCommissions($value, $commission, $withSymbol = true, $divider = 1, $round = false)
    {
        if($withSymbol) {
            return Number::currency(($value / 1000000) * ((100 - $commission) / 100));
        }

        $initialValue = ($value / $divider)  * ((100 - $commission) / 100);
        return Number::abbreviate( $round ? round($initialValue) : $initialValue, 2);
    }
}

