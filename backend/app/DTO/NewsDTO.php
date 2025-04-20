<?php

namespace App\DTO;

class NewsDTO
{
    public function __construct(
        public string $title,
        public string $slug,
        public string $content,
        public int $author_id,
        public int $category_id,
        public string $publish_date,
        public ?string $description = null
    ) {}
}
