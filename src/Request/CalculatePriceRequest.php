<?php

namespace App\Request;

use App\Enum\CountryTaxFormatEnum;
use App\Enum\CouponEnum;
use Symfony\Component\Validator\Constraints\AtLeastOneOf;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

class CalculatePriceRequest extends BaseRequest
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
}