<?php

namespace App\Payment;

use App\Exception\PaymentException;

interface PaymentInterface
{
    /**
     * @throws PaymentException
     */
    public function purchase(float $price): bool;
}