<?php

namespace App\Services\Auth;

use App\DTOs\Auth\AuthRegisterDTO;
use App\DTOs\Auth\AuthLoginDTO;
use App\Models\User;
use App\Repositories\Auth\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    public function __construct(protected AuthRepositoryInterface $authRepo) {}

    public function register(AuthRegisterDTO $dto): void
    {
        $this->authRepo->createUser($dto);
    }

    public function login(AuthLoginDTO $dto): string
    {
        $user = User::where('email', $dto->email)->first();

        if (!$user || !Hash::check($dto->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Thông tin đăng nhập không đúng'],
            ]);
        }

        return $user->createToken('auth_token')->plainTextToken;
    }
        public function logout(): void
        {
            $user = auth()->user();
            
            $user->currentAccessToken()->delete();
        }

}
