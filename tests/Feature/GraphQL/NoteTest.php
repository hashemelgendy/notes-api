<?php

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();

    $registerMutation = <<<'GRAPHQL'
    mutation {
        login(input: {
            username: "%s"
            password: "password"
        }) {
            token
        }
    }
    GRAPHQL;

    $tokenResponse = $this->postJson('/graphql', [
        'query' => sprintf($registerMutation, $this->user->username),
    ]);

    $this->token = $tokenResponse->json('data.login.token');
});

it('creates a note via GraphQL', function () {
    $mutation = <<<'GRAPHQL'
    mutation {
        createNote(input: {
            title: "Test Note"
            body: "Some body content here"
        }) {
            id
            title
            body
        }
    }
    GRAPHQL;

    $response = $this->postJson('/graphql', ['query' => $mutation], [
        'Authorization' => 'Bearer ' . $this->token,
    ]);

    $response->assertStatus(200)
        ->assertJsonPath('data.createNote.title', 'Test Note');
});

it('lists notes for authenticated user via GraphQL', function () {
    Note::factory()->count(3)->create(['user_id' => $this->user->id]);
    Note::factory()->create();

    $query = <<<'GRAPHQL'
    query {
        notes {
            id
            title
            body
        }
    }
    GRAPHQL;

    $response = $this->postJson('/graphql', ['query' => $query], [
        'Authorization' => 'Bearer ' . $this->token,
    ]);

    $response->assertStatus(200);
    expect(count($response->json('data.notes')))->toBe(3);
});

it('updates own note via GraphQL', function () {
    $note = Note::factory()->create(['user_id' => $this->user->id]);

    $mutation = <<<GRAPHQL
    mutation {
        updateNote(id: {$note->id}, input: {
            title: "Updated Title"
            body: "Updated body content"
        }) {
            id
            title
            body
        }
    }
    GRAPHQL;

    $response = $this->postJson('/graphql', ['query' => $mutation], [
        'Authorization' => 'Bearer ' . $this->token,
    ]);

    $response->assertStatus(200)
        ->assertJsonPath('data.updateNote.title', 'Updated Title');
});

it('does not update others\' notes via GraphQL', function () {
    $note = Note::factory()->create();

    $mutation = <<<GRAPHQL
    mutation {
        updateNote(id: {$note->id}, input: {
            title: "Hacked Title"
            body: "Hacked body content"
        }) {
            id
            title
        }
    }
    GRAPHQL;

    $response = $this->postJson('/graphql', ['query' => $mutation], [
        'Authorization' => 'Bearer ' . $this->token,
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['errors']);
});

it('deletes own note via GraphQL', function () {
    $note = Note::factory()->create(['user_id' => $this->user->id]);

    $mutation = <<<GRAPHQL
    mutation {
        deleteNote(id: {$note->id}) {
            status
        }
    }
    GRAPHQL;

    $response = $this->postJson('/graphql', ['query' => $mutation], [
        'Authorization' => 'Bearer ' . $this->token,
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseMissing('notes', ['id' => $note->id]);
});

it('does not delete others\' notes via GraphQL', function () {
    $note = Note::factory()->create();

    $mutation = <<<GRAPHQL
    mutation {
        deleteNote(id: {$note->id}) {
            status
        }
    }
    GRAPHQL;

    $response = $this->postJson('/graphql', ['query' => $mutation], [
        'Authorization' => 'Bearer ' . $this->token,
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['errors']);
});

it('requires authentication for note actions via GraphQL', function () {
    $create = <<<'GRAPHQL'
    mutation {
        createNote(input: {
            title: "No Auth"
            body: "No auth body"
        }) {
            id
        }
    }
    GRAPHQL;

    $response = $this->postJson('/graphql', ['query' => $create]);
    $response->assertStatus(200)->assertJsonStructure(['errors']);
});
