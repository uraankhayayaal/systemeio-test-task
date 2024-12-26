<?php

namespace App\Requests;

use App\Enums\CountryTaxFormatEnum;
use App\Enums\CouponEnum;
use App\Enums\PaymentEnum;
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
        new Regex(CountryTaxFormatEnum::GERNAMY->value),
        new Regex(CountryTaxFormatEnum::ITALY->value),
        new Regex(CountryTaxFormatEnum::FRANCE->value),
        new Regex(CountryTaxFormatEnum::GREECE->value),
    ])]
    #[NotBlank([])]
    public $taxNumber;

    #[Choice(callback: [CouponEnum::class, 'values'])]
    #[NotBlank([])]
    public $couponCode;

    #[Choice(callback: [PaymentEnum::class, 'values'])]
    #[NotBlank([])]
    public $paymentProcessor;
}