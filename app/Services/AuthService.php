<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(string $username, string $password): User
    {
        $user = User::create([
            'username' => $username,
            'password' => Hash::make($password),
        ]);

        return $user->createToken('auth_token')->plainTextToken;
    }

    public function login(string $username, string $password): string
    {
        $user = User::where('username', $username)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken('auth_token')->plainTextToken;
    }
}
