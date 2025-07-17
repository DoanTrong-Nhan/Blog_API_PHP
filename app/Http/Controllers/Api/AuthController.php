<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DTOs\Auth\AuthRegisterDTO;
use App\DTOs\Auth\AuthLoginDTO;
use App\Http\Requests\Auth\LoginRequest as AuthLoginRequest;
use App\Http\Requests\Auth\RegisterRequest as AuthRegisterRequest;
use App\Services\Auth\AuthServiceInterface;

class AuthController extends Controller
{
    public function __construct(protected AuthServiceInterface $authService) {}

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Auth"},
     *     summary="Đăng ký người dùng mới",
    * @OA\RequestBody(
    *     required=true,
    *     @OA\JsonContent(
    *         required={"name","email","password","password_confirmation"},
    *         @OA\Property(property="name", type="string", example="Nguyen Van A"),
    *         @OA\Property(property="email", type="string", example="a@example.com"),
    *         @OA\Property(property="password", type="string", format="password", example="12345678"),
    *         @OA\Property(property="password_confirmation", type="string", format="password", example="12345678")
    *     )
    * ),

     *     @OA\Response(
     *         response=201,
     *         description="Đăng ký thành công"
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Đăng nhập và lấy access token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="a@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Đăng nhập thành công, trả về access token"
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Auth"},
     *     summary="Đăng xuất người dùng hiện tại",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Đăng xuất thành công"
     *     )
     * )
     */
    public function logout()
    {
        $this->authService->logout();

        return response()->json(['message' => 'Đăng xuất thành công']);
    }
}
