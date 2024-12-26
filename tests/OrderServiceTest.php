<?php

namespace App\Tests;

use App\Enum\CountryTaxFormatEnum;
use App\Enum\CouponEnum;
use App\Helper\ReflectionHelper;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderServiceTest extends WebTestCase
{
    private OrderService $orderService;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->orderService = $container->get(OrderService::class);
    }

    public function testPriceCalculationSuccess(): void
    {
        $price = ReflectionHelper::ivokePrivateMethod(
            $this->orderService,
            'getFinalPriceByTaxAndCoupon',
            [
                100,
                CountryTaxFormatEnum::GERNAMY,
                CouponEnum::SALE_QUARTER,
            ],
        );

        $this->assertEquals(89.25, $price);
    }

    public function testPriceCalculationReturnZeroIfCouponGteThanPriceSuccess(): void
    {
        $price = ReflectionHelper::ivokePrivateMethod(
            $this->orderService,
            'getFinalPriceByTaxAndCoupon',
            [
                5,
                CountryTaxFormatEnum::GERNAMY,
                CouponEnum::SALE_5,
            ],
        );

        $this->assertEquals(0, $price);
    }

    public function testPriceCalculationReturnZeroForFullSale(): void
    {
        $price = ReflectionHelper::ivokePrivateMethod(
            $this->orderService,
            'getFinalPriceByTaxAndCoupon',
            [
                10000000,
                CountryTaxFormatEnum::ITALY,
                CouponEnum::SALE_FULL,
            ],
        );

        $this->assertEquals(0, $price);
    }
}