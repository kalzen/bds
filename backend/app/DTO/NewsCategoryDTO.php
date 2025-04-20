<?php

namespace App\DTO;

class NewsCategoryDTO
{
    public function __construct(
        public string $name,
        public string $slug,
        public ?string $description = null
    ) {}
}
