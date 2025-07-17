<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\DTOs\Auth\AuthRegisterDTO;

interface AuthRepositoryInterface
{
    public function createUser(AuthRegisterDTO $dto): User;
}
