<?php

namespace App\Payment;

use App\Exception\PaymentException;
use App\Helper\CurrencyHelper;
use Psr\Log\LoggerInterface;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class PaypalPayment implements PaymentInterface
{
    private PaypalPaymentProcessor $proccessor;

    public function __construct(
        private LoggerInterface $logger,
    ){
        $this->init();
    }

    private function init(): void
    {
        $this->proccessor = new PaypalPaymentProcessor();
    }

    public function purchase(float $price): bool
    {
        $unit = CurrencyHelper::getUnitsFromCurrency($price);

        try {
            $this->proccessor->pay($unit);
        } catch (\Exception $exception) {
            throw new PaymentException($exception->getMessage(), 0, $exception);
        }

        return true;
    }
}