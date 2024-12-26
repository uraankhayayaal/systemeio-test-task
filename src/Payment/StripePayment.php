<?php

namespace App\Payment;

use App\Exception\PaymentException;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class StripePayment implements PaymentInterface
{
    const MIN_PRICE = 100;

    private StripePaymentProcessor $proccessor;

    public function __construct()
    {
        $this->init();
    }

    private function init(): void
    {
        $this->proccessor = new StripePaymentProcessor();
    }

    public function purchase(float $price): bool
    {
        if ($price < self::MIN_PRICE) {
            throw new PaymentException('Minimum ' . self::MIN_PRICE . ' units of currecny required');
        }

        return $this->proccessor->processPayment($price);
    }
}