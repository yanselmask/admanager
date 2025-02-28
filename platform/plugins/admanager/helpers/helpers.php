<?php

if(!function_exists('getValueWithCommissions'))
{
    function getValueWithCommissions($value, $commission, $withSymbol = true, $divider = 1, $round = false, $includePercentage = false)
    {
        if($withSymbol) {

            if($includePercentage)
            {
                return Number::currency(($value / 1000000) * ((100 - $commission) / 100));
            }

            return Number::currency(($value / 1000000));
        }

        if($includePercentage) {
            $initialValue = ($value / $divider)  * ((100 - $commission) / 100);
        }else{
            $initialValue = ($value / $divider);
        }

        return Number::abbreviate( $round ? round($initialValue) : $initialValue, 2);
    }
}

if(!function_exists('getValueWithCommissionsInverse'))
{
    function getValueWithCommissionsInverse($value, $commission, $withSymbol = true, $includePercentage = false)
    {
        if($withSymbol) {
            if($includePercentage)
            {
                return Number::currency(($value / 1000000) * (($commission) / 100));
            }
            return Number::currency(($value / 1000000));
        }
    }
}

