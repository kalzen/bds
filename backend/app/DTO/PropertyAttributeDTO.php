<?php

namespace App\DTO;

class PropertyAttributeDTO
{
    public function __construct(
        public int $property_id,
        public int $attribute_id,
        public string $value
    ) {}
}
