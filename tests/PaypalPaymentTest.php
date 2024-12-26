<?php

namespace App\Tests;

use App\Exception\PaymentException;
use App\Payment\PaymentInterface;
use App\Payment\PaypalPayment;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaypalPaymentTest extends WebTestCase
{
    private PaymentInterface $payment;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->payment = $container->get(PaypalPayment::class);
    }

    public function testPurchaseSuccess(): void
    {
        $isPaid = $this->payment->purchase(100);

        $this->assertEquals(true, $isPaid);
    }

    public function testPurchaseFails(): void
    {
        $tooHigthtPrice = 10000000;

        try {
            $this->payment->purchase($tooHigthtPrice);
        } catch (Exception $exception) {
            $this->assertInstanceOf(PaymentException::class, $exception);
            $this->equalTo('[#14271] Transaction "c82711ca-7e67-41c8-9f35-5b965e645d12" failed: Too high price', $exception->getMessage());
        }
    }
}