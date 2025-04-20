<?php

namespace App\DTO;

class LocationDTO
{
    public function __construct(
        public int $ward_id,
        public string $address,
        public float $latitude,
        public float $longitude
    ) {}
}
