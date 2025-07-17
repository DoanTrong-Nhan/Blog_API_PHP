<?php

namespace App\DTOs\Auth;

class AuthLoginDTO
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
