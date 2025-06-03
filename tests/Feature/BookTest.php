<?php

use App\Models\User;
use App\Models\Books;
use App\Models\Authors;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function mocksBooks()
{
    $authors = Authors::factory(2)->create();
    $books = Books::factory()->count(3)->create()->each(function ($book) use ($authors) {
        $book->authors()->attach($authors->pluck('id'));
    });

    return [
        'books' => $books,
        'authors' => $authors,
    ];
}


it('gets all books', function () {
    $user = login();
    $this->actingAs($user);

    $mock = mocksBooks();

    $response = $this->get('/api/book/index');
    $response->assertStatus(200);

    $data = $response->json();
    expect($data['data'])->toHaveCount(3);
});

it('gets a single book by id', function () {
    $user = login();
    $this->actingAs($user);

    $mock = mocksBooks();

    $book = $mock['books'][0];

    $response = $this->get('/api/book/show/' . $book->id);
    $response->assertStatus(200);

    $data = $response->json();
    expect($data['id'])->toBe($book->id);
});

it('creates a book', function () {
    $user = login();
    $this->actingAs($user);

    $authors = Authors::factory(2)->create();

    $data = [
        'title' => 'Novo Livro',
        'publish_date' => '2024-06-01',
        'authors' => [
            ['author_id' => $authors[0]->id],
            ['author_id' => $authors[1]->id],
        ],
    ];

    $response = $this->post('/api/book/store', $data);
    $response->assertStatus(200);

    $book = $response->json();
    expect($book['title'])->toBe('Novo Livro');
});

it('updates a book', function () {
    $user = login();
    $this->actingAs($user);

    $mock = mocksBooks();
    $book = $mock['books'][0];

    $data = [
        'title' => 'Livro Atualizado',
        'publish_date' => '2022-05-10',
        'authors' => [
            ['author_id' => $mock['authors'][0]->id]
        ],
    ];

    $response = $this->put('/api/book/update/' . $book->id, $data);
    $response->assertStatus(200);

    $updated = $response->json();
    expect($updated['title'])->toBe('Livro Atualizado');
    expect($updated['id'])->toBe($book->id);
});

it('deletes a book', function () {
    $user = login();
    $this->actingAs($user);

    $mock = mocksBooks();
    $book = $mock['books'][0];

    $response = $this->delete('/api/book/delete/' . $book->id);
    $response->assertStatus(200);

    $this->assertDatabaseMissing('books', ['id' => $book->id]);
});
