<?php

use App\Models\Authors;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function mocks()
{
    $author = Authors::factory(3)->create();
    return [
        'author' => $author,
    ];
}

function login()
{
    return User::factory()->create();
}

it('gets all authors', function () {
    $user = login();
    $this->actingAs($user);

    $mock = mocks();

    $response = $this->get('/api/author/index');
    $response->assertStatus(200);

    $responseData = $response->json();
    expect(count($responseData['data']))->toBe(3);
});

it('gets author by id', function () {
    $user = login();
    $this->actingAs($user);

    $mock = mocks();

    $response = $this->get('/api/author/show/' . $mock['author'][0]->id);
    $response->assertStatus(200);

    $responseData = $response->json();
    expect($responseData['id'])->toBe($mock['author'][0]->id);
});

it('creates an author', function () {
    $user = login();
    $this->actingAs($user);

    mocks();

    $data = [
        'name' => 'teste',
        'birth_date' => '1995-07-04',
    ];

    $response = $this->post('/api/author/store', $data);
    $response->assertStatus(200);

    $responseData = $response->json();
    expect($responseData['name'])->toBe('teste');
});

it('updates an author', function () {
    $user = login();
    $this->actingAs($user);

    $mock = mocks();

    $data = [
        'name' => $mock['author'][0]->name,
        'birth_date' => '1995-07-04',
    ];

    $response = $this->put('/api/author/update/' . $mock['author'][0]->id, $data);
    $response->assertStatus(200);

    $responseData = $response->json();
    expect($responseData['id'])->toBe($mock['author'][0]->id);
    expect($responseData['birth_date'])->toBe('1995-07-04');
});

it('deletes an author', function () {
    $user = login();
    $this->actingAs($user);

    $mock = mocks();

    $response = $this->delete('/api/author/delete/' . $mock['author'][0]->id);
    $response->assertStatus(200);
});
