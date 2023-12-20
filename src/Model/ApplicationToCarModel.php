<?php

namespace App\Model;

use DateTimeInterface;

readonly class ApplicationToCarModel
{
    public function __construct(

        public CarModel $carModel,
        public CreditModel $creditModel,
        public DateTimeInterface $date,
    )
    {
    }
}