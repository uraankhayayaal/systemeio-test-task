<?php

namespace App\Enum;

enum CountryTaxFormatEnum: string
{
    case GERNAMY = '/^DE[0-9]{9}$/';
    case ITALY = '/^IT[0-9]{11}$/';
    case FRANCE = '/^FR[a-zA-Z]{2}[0-9]{9}$/';
    case GREECE = '/^GR[0-9]{9}$/';

    public function taxValue(): float
    {
        return match ($this) {
            self::GERNAMY => 0.19,
            self::ITALY => 0.22,
            self::FRANCE => 0.20,
            self::GREECE => 0.24,
        };
    }
}