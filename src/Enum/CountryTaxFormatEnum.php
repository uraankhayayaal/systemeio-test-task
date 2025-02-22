<?php

namespace App\Enum;

enum CountryTaxFormatEnum: string
{
    case GERMANY = '/^DE[0-9]{9}$/';
    case ITALY = '/^IT[0-9]{11}$/';
    case FRANCE = '/^FR[a-zA-Z]{2}[0-9]{9}$/';
    case GREECE = '/^GR[0-9]{9}$/';

    public function taxValue(): float
    {
        return match ($this) {
            self::GERMANY => 0.19,
            self::ITALY => 0.22,
            self::FRANCE => 0.20,
            self::GREECE => 0.24,
            default => 0,
        };
    }

    public static function tryFormat(string $taxNumber): self
    {
        foreach (self::cases() as $case) {
            if (preg_match($case->value, $taxNumber)) {
                return $case;
            }
        }
    }

    public function getTaxedFromPrice(int $price): int
    {
        return $price + $price * $this->taxValue();
    }
}