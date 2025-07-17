<?php

namespace App\Services\Auth;

use App\DTOs\Auth\AuthRegisterDTO;
use App\DTOs\Auth\AuthLoginDTO;

interface AuthServiceInterface
{
    public function register(AuthRegisterDTO $dto): void;
    public function login(AuthLoginDTO $dto): string;
    public function logout(): void;
}
