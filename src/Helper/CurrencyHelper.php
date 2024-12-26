<?php

namespace App\Helper;

class CurrencyHelper
{
    const UNITS_IN_ONE_CURRENCY = 100;

    public static function getUnitsFromCurrency(float $price): int
    {
        return intval($price * self::UNITS_IN_ONE_CURRENCY);
    }

    public static function geCurrencyFromUnits(int $unit): float
    {
        return $unit / self::UNITS_IN_ONE_CURRENCY;
    }
}