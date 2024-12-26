<?php

namespace App\Tests;

use App\Exception\PaymentException;
use App\Payment\PaymentInterface;
use App\Payment\StripePayment;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StripePaymentTest extends WebTestCase
{
    private PaymentInterface $payment;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->payment = $container->get(StripePayment::class);
    }

    public function testPurchaseSuccess(): void
    {
        $isPaid = $this->payment->purchase(101);

        $this->assertEquals(true, $isPaid);
    }

    public function testPurchaseFails(): void
    {
        $tooLowPrice = 10;

        try {
            $this->payment->purchase($tooLowPrice);
        } catch (Exception $exception) {
            $this->assertInstanceOf(PaymentException::class, $exception);
            $this->equalTo("Minimum $tooLowPrice units of currecny required", $exception->getMessage());
        }
    }
}
