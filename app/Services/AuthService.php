<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(string $username, string $password): array
    {
        $user = User::create([
            'username' => $username,
            'password' => Hash::make($password),
        ]);

        return [
            'user' => $user,
            'token'=> $user->createToken('auth_token')->plainTextToken
        ];
    }

    public function login(string $username, string $password): array
    {
        $user = User::where('username', $username)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        return [
            'user' => $user,
            'token'=> $user->createToken('auth_token')->plainTextToken
        ];
    }
}
