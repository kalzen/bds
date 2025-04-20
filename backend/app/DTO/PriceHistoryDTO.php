<?php

namespace App\DTO;

class PriceHistoryDTO
{
    public function __construct(
        public int $property_id,
        public float $price,
        public ?string $changed_at = null
    ) {}
}
