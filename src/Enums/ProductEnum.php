<?php

namespace App\Enums;

enum ProductEnum: int
{
    case IPHONE = 1;
    case HEADPHONES = 2;
    case CASE = 3;

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function price(): int
    {
        return match ($this) {
            self::IPHONE => 100,
            self::HEADPHONES => 20,
            self::CASE => 10,
        };
    }
}