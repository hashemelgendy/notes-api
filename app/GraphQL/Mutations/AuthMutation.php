<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthMutation
{
    public function __construct(protected AuthService $authService) {}

    public function register($_, array $args): array
    {
        return $this->authService->register($args['username'], $args['password']);
    }

    public function login($_, array $args): array
    {
        return $this->authService->login($args['username'], $args['password']);
    }
}
