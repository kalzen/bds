<?php

namespace App\DTO;

class ProjectDTO
{
    public function __construct(
        public string $name,
        public string $investor,
        public int $location_id,
        public float $total_area,
        public int $number_of_units,
        public ?string $description = null,
        public string $start_date,
        public ?string $end_date = null
    ) {}
}
