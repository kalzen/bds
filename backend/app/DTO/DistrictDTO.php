<?php

namespace App\DTO;

class DistrictDTO
{
    public function __construct(
        public int $city_id,
        public string $name
    ) {}
}
