<?php

namespace App\Model;

readonly class CreditModel
{
    public function __construct(
        public ?int $fullyPrice,
        public ?int $monthlyPaymentAmount,
        public ?float $interestRate,
    )
    {
    }
}