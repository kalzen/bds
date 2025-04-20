<?php

namespace App\DTO;

class PropertyDTO
{
    public function __construct(
        public int $user_id,
        public int $listing_type_id,
        public int $category_id,
        public int $location_id,
        public string $title,
        public float $price,
        public string $legal_status,
        public string $direction,
        public ?int $project_id = null,
        public ?int $attribute_id = null,
        public ?string $description = null,
        public ?string $furniture = null
    ) {}
}
