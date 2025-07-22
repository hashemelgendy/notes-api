<?php

namespace App\GraphQL\Mutations;

use App\Services\AuthService;

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
