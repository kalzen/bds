<?php

namespace App\DTO;

class PropertyAmenityDTO
{
    public function __construct(
        public int $property_id,
        public int $amenity_id
    ) {}
}
