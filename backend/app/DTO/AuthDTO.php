<?php

namespace App\DTO;

class AuthDTO
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
