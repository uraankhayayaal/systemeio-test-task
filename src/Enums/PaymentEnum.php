<?php

namespace App\Enums;

enum PaymentEnum: string
{
    case PAYPAL = 'paypal';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}