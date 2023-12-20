<?php

namespace App\Model;

readonly class CarModel
{
    public function __construct(
        public ?string $brand,
        public ?string $model,
        public ?string $image,
        public  int $price
    )
    {
    }
}