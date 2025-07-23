<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registers a user via GraphQL', function () {
    $mutation = <<<'GRAPHQL'
    mutation {
        register(
            username: "hashem"
            password: "password"
            password_confirmation: "password"
        ) {
            token
            user {
                id
                username
            }
        }
    }
    GRAPHQL;

    $response = $this->postJson('/graphql', ['query' => $mutation]);

    $response->assertStatus(200)
        ->assertJsonPath('data.register.user.username', 'hashem')
        ->assertJsonStructure([
            'data' => [
                'register' => [
                    'token',
                    'user' => ['id', 'username'],
                ],
            ],
        ]);
});

it('rejects duplicate username registration via GraphQL', function () {
    $mutation = <<<'GRAPHQL'
    mutation {
        register(
            username: "duplicate"
            password: "password"
            password_confirmation: "password"
        ) {
            token
            user {
                id
                username
            }
        }
    }
    GRAPHQL;

    $this->postJson('/graphql', ['query' => $mutation]);
    $response = $this->postJson('/graphql', ['query' => $mutation]);

    $response->assertStatus(200)
        ->assertJsonPath('errors.0.extensions.validation.username.0', 'The username has already been taken.');
});

it('fails registration with invalid input via GraphQL', function () {
    $mutation = <<<'GRAPHQL'
    mutation {
        register(
            username: ""
            password: "123"
            password_confirmation: "456"
        ) {
            token
            user {
                id
                username
            }
        }
    }
    GRAPHQL;

    $response = $this->postJson('/graphql', ['query' => $mutation]);

    $response->assertStatus(200)
        ->assertJsonStructure(['errors']);
});

it('logs in successfully via GraphQL', function () {
    $register = <<<'GRAPHQL'
    mutation {
        register(
            username: "hashem_login"
            password: "password"
            password_confirmation: "password"
        ) {
            token
            user {
                id
                username
            }
        }
    }
    GRAPHQL;

    $this->postJson('/graphql', ['query' => $register]);

    $mutation = <<<'GRAPHQL'
    mutation {
        login(
            username: "hashem_login"
            password: "password"
        ) {
            token
            user {
                id
                username
            }
        }
    }
    GRAPHQL;

    $response = $this->postJson('/graphql', ['query' => $mutation]);

    $response->assertStatus(200)
        ->assertJsonPath('data.login.user.username', 'hashem_login')
        ->assertJsonStructure([
            'data' => [
                'login' => [
                    'token',
                    'user' => ['id', 'username'],
                ],
            ],
        ]);
});

it('fails login with invalid credentials via GraphQL', function () {
    $mutation = <<<'GRAPHQL'
    mutation {
        login(
            username: "nonexistent"
            password: "wrong"
        ) {
            token
            user {
                id
                username
            }
        }
    }
    GRAPHQL;

    $response = $this->postJson('/graphql', ['query' => $mutation]);

    $response->assertStatus(200)
        ->assertJsonStructure(['errors']);
});
