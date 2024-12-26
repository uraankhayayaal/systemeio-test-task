<?php

namespace App\Enum;

use App\Helper\CurrencyHelper;

enum CouponEnum: string
{
    case SALE_FULL = 'sale_100_percent';
    case SALE_HALF = 'sale_50_percent';
    case SALE_THIRD = 'sale_33_percent';
    case SALE_QUARTER = 'sale_25_percent';

    case SALE_1 = 'sale_1';
    case SALE_2 = 'sale_2';
    case SALE_5 = 'sale_5';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getSaleFromPrice(int $value): int
    {
        return match ($this) {
            self::SALE_FULL,
            self::SALE_HALF,
            self::SALE_THIRD,
            self::SALE_QUARTER => $this->salePercent($value),
            self::SALE_1,
            self::SALE_2,
            self::SALE_5 => $this->saleUnuit($value),
        };
    }

    private function salePercent(int $value): int
    {
        $priceAfterSale = intval($value - $value * $this->percentValue());

        return $priceAfterSale;
    }

    private function saleUnuit(int $value): int
    {
        $priceAfterSale = intval($value - $this->unitValue());

        if ($priceAfterSale < 0) {
            return 0;
        }

        return $priceAfterSale;
    }

    private function percentValue(): float
    {
        return match ($this) {
            self::SALE_FULL => 1,
            self::SALE_HALF => 0.5,
            self::SALE_THIRD => 0.33,
            self::SALE_QUARTER => 0.25,
            default => 0,
        };
    }

    private function unitValue(): int
    {
        return match ($this) {
            self::SALE_1 => CurrencyHelper::getUnitsFromCurrency(1),
            self::SALE_2 => CurrencyHelper::getUnitsFromCurrency(2),
            self::SALE_5 => CurrencyHelper::getUnitsFromCurrency(5),
            default => 0,
        };
    }
}