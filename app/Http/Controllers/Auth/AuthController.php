<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends ApiController
{
    public function __construct(protected AuthService $authService) {}

    /**
     * Register
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        return $this->success($this->authService->register($data['username'], $data['password']), 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        return $this->success($this->authService->login($data['username'], $data['password']), 201);
    }

    /**
     * Logout
     */
    public function logout(): JsonResponse
    {
        request()->user()->currentAccessToken()->delete();

        return $this->success(['message' => 'Logged out']);
    }
}
