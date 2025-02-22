<?php

namespace App\Service;

use App\Enum\CountryTaxFormatEnum;
use App\Enum\CouponEnum;
use App\Enum\ProductEnum;
use App\Helper\CurrencyHelper;
use App\Payment\PaymentInterface;
use App\Request\CalculatePriceRequest;
use App\Request\PurchaseRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderService
{
    public function calculatePrice(CalculatePriceRequest $request): float
    {
        // Fake the repository and entity
        $product = ProductEnum::tryFrom($request->product);

        if ($product === null) {
            throw new NotFoundHttpException("Product with id: $request->product not found");
        }
    
        // Fake the repository and entity
        $coupon = CouponEnum::tryFrom($request->couponCode);

        // Fake the repository and entity
        $countryTax = CountryTaxFormatEnum::tryFormat($request->taxNumber);

        return $this->getFinalPriceByTaxAndCoupon($product->price(), $countryTax, $coupon);
    }

    public function purchase(PurchaseRequest $request, PaymentInterface $payment): bool
    {
        // Fake the repository and entity
        $product = ProductEnum::tryFrom($request->product);
    
        // Fake the repository and entity
        $coupon = CouponEnum::tryFrom($request->couponCode);

        // Fake the repository and entity
        $countryTax = CountryTaxFormatEnum::tryFormat($request->taxNumber);
        
        $price = $this->getFinalPriceByTaxAndCoupon($product->price(), $countryTax, $coupon);

        return $payment->purchase($price);
    }

    private function getFinalPriceByTaxAndCoupon(float $price, CountryTaxFormatEnum $countryTax, ?CouponEnum $coupon): float
    {
        $finalPrice = CurrencyHelper::getUnitsFromCurrency($price);

        $coupon && $finalPrice = $coupon->getSaleFromPrice($finalPrice);

        $finalPrice = $countryTax->getTaxedFromPrice($finalPrice);

        return CurrencyHelper::geCurrencyFromUnits($finalPrice);
    }
}