<?php

namespace App\DTO;

class WardDTO
{
    public function __construct(
        public int $district_id,
        public string $name
    ) {}
}
