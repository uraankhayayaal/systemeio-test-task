<?php

namespace App\Request;

use App\Enum\CountryTaxFormatEnum;
use App\Enum\CouponEnum;
use App\Enum\PaymentEnum;
use Symfony\Component\Validator\Constraints\AtLeastOneOf;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

class PurchaseRequest extends BaseRequest
{
    #[Type('integer')]
    #[NotBlank()]
    public $product;

    #[AtLeastOneOf([
        new Regex(CountryTaxFormatEnum::GERMANY->value, message: "Germany"),
        new Regex(CountryTaxFormatEnum::ITALY->value, message: "Italy"),
        new Regex(CountryTaxFormatEnum::FRANCE->value, message: "France"),
        new Regex(CountryTaxFormatEnum::GREECE->value, message: "Greece"),
    ], message: "The tax number does not match any format of countries:")]
    #[NotBlank([])]
    public $taxNumber;

    #[Choice(callback: [CouponEnum::class, 'values'], message: 'Wrong coupon number')]
    public $couponCode;

    #[Choice(callback: [PaymentEnum::class, 'values'], message: 'Wrong payment method')]
    #[NotBlank([])]
    public $paymentProcessor;
}