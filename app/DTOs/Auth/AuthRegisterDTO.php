<?php 

namespace App\DTOs\Auth;

class AuthRegisterDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}
}
