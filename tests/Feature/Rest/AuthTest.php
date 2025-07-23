<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registers a user successfully', function () {
    $response = $this->postJson('/api/register', [
        'username' => 'hashem',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertCreated()
        ->assertJsonStructure([
            'status',
            'data' => [
                'user' => ['id', 'username'],
                'token',
            ],
        ]);
});

it('rejects duplicate username registration', function () {
    $this->postJson('/api/register', [
        'username' => 'hashem',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response = $this->postJson('/api/register', [
        'username' => 'hashem',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);
});

it('fails registration with invalid input', function () {
    $response = $this->postJson('/api/register', [
        'username' => '',
        'password' => '123',
    ]);

    $response->assertStatus(422);
});

it('logs in successfully with correct credentials', function () {
    $this->postJson('/api/register', [
        'username' => 'hashem_login',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response = $this->postJson('/api/login', [
        'username' => 'hashem_login',
        'password' => 'password',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'status',
            'data' => [
                'user' => ['id', 'username'],
                'token',
            ],
        ]);
});

it('fails to login with invalid credentials', function () {
    $response = $this->postJson('/api/login', [
        'username' => 'nonexistent',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401);
});
