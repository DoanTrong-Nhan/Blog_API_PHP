<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\DTOs\Auth\AuthRegisterDTO;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    public function createUser(AuthRegisterDTO $dto): User
    {
        return User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'role_id' => 2, // Gán mặc định User role
        ]);
    }
}
