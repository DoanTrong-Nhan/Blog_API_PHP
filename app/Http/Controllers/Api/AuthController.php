<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DTOs\Auth\AuthRegisterDTO;
use App\DTOs\Auth\AuthLoginDTO;
use App\Http\Requests\Auth\LoginRequest as AuthLoginRequest;
use App\Http\Requests\Auth\RegisterRequest as AuthRegisterRequest;
use App\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthServiceInterface;

class AuthController extends Controller
{
    public function __construct(protected AuthServiceInterface $authService) {}

    public function register(AuthRegisterRequest $request)
    {
        $dto = new AuthRegisterDTO(
            name: $request->name,
            email: $request->email,
            password: $request->password
        );

        $this->authService->register($dto);

        return response()->json(['message' => 'Đăng ký thành công'], 201);
    }

    public function login(AuthLoginRequest $request)
    {
        $dto = new AuthLoginDTO(
            email: $request->email,
            password: $request->password
        );

        $token = $this->authService->login($dto);

        return response()->json([
            'message' => 'Đăng nhập thành công',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout()
    {
        $this->authService->logout();

        return response()->json(['message' => 'Đăng xuất thành công']);
    }
}
