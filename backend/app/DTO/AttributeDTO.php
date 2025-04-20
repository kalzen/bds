<?php

namespace App\DTO;

class AttributeDTO
{
    public function __construct(
        public string $name,
        public string $data_type,
        public ?string $unit = null
    ) {}
}
