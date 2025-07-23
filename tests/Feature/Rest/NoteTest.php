<?php

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $loginResponse = $this->postJson('/api/login', [
        'username' => $this->user->username,
        'password' => 'password',
    ]);
    $this->token = $loginResponse->json('data.token');

    // Reusable data for notes
    $this->defaultTitle = 'Test Note';
    $this->defaultBody = 'Some body content here';

    $this->updatedTitle = 'Updated Title';
    $this->updatedBody = 'Updated body content';

    $this->hackedTitle = 'Hacked Title';
    $this->hackedBody = 'Hacked body content';

    $this->noAuthTitle = 'No Auth';
    $this->noAuthBody = 'No auth body';
});

it('creates a note', function () {
    $response = $this->postJson('/api/notes', [
        'title' => $this->defaultTitle,
        'body' => $this->defaultBody,
    ], ['Authorization' => 'Bearer '.$this->token]);

    $response->assertCreated();
    $this->assertDatabaseHas('notes', [
        'title' => $this->defaultTitle,
        'body' => $this->defaultBody,
        'user_id' => $this->user->id,
    ]);
});

it('lists notes for authenticated user', function () {
    Note::factory()->count(3)->create(['user_id' => $this->user->id]);
    Note::factory()->create(); // Note for another user

    $response = $this->getJson('/api/notes', [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertOk();
    $data = $response->json('data.notes');
    expect(count($data))->toBe(3);
});

it('updates own note', function () {
    $note = Note::factory()->create(['user_id' => $this->user->id]);

    $response = $this->putJson("/api/notes/{$note->id}", [
        'title' => $this->updatedTitle,
        'body' => $this->updatedBody,
    ], ['Authorization' => 'Bearer '.$this->token]);

    $response->assertOk();
    $this->assertDatabaseHas('notes', [
        'id' => $note->id,
        'title' => $this->updatedTitle,
        'body' => $this->updatedBody,
    ]);
});

it('does not update others\' notes', function () {
    $otherNote = Note::factory()->create();

    $response = $this->putJson("/api/notes/{$otherNote->id}", [
        'title' => $this->hackedTitle,
        'body' => $this->hackedBody,
    ], ['Authorization' => 'Bearer '.$this->token]);

    $response->assertStatus(403);
});

it('deletes own note', function () {
    $note = Note::factory()->create(['user_id' => $this->user->id]);

    $response = $this->deleteJson("/api/notes/{$note->id}", [], [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertOk();
    $this->assertDatabaseMissing('notes', ['id' => $note->id]);
});

it('does not delete others\' notes', function () {
    $otherNote = Note::factory()->create();

    $response = $this->deleteJson("/api/notes/{$otherNote->id}", [], [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertStatus(403);
});

it('requires authentication for all note actions', function () {
    $response = $this->postJson('/api/notes', [
        'title' => $this->noAuthTitle,
        'body' => $this->noAuthBody,
    ]);
    $response->assertStatus(401);

    $response = $this->getJson('/api/notes');
    $response->assertStatus(401);

    $response = $this->putJson('/api/notes/1', [
        'title' => $this->noAuthTitle,
        'body' => $this->noAuthBody,
    ]);
    $response->assertStatus(401);

    $response = $this->deleteJson('/api/notes/1');
    $response->assertStatus(401);
});
