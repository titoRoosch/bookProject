<?php

use App\Models\Authors;
use App\Models\Books;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function mocksBooks() {
    $author = Authors::factory()->create();
    $books = Books::factory(3)->create();

    foreach ($books as $book) {
        $book->authors()->attach($author->id);
    }

    return [
        'author' => $author,
        'books' => $books,
    ];
}

test('it gets all books', function () {
    $mock = mocksBooks();

    $response = $this->json('get', '/api/book/index');
    $response->assertStatus(200);

    $responseData = $response->json();
    expect(count($responseData['data']))->toBe(3);
});

test('it gets book by id', function () {
    $mock = mocksBooks();

    $response = $this->json('get', '/api/book/show/' . $mock['books'][0]->id);
    $response->assertStatus(200);

    $responseData = $response->json();
    expect($responseData['id'])->toBe($mock['books'][0]->id);
});

test('it creates a book', function () {
    $mock = mocksBooks();

    $data = [
        'title' => 'teste',
        'publish_date' => '1995-04-08',
        'authors' => [
            ['author_id' => $mock['author']->id]
        ],
    ];

    $response = $this->json('post', '/api/book/store', $data);
    $response->assertStatus(200);

    $responseData = $response->json();
    expect($responseData['title'])->toBe('teste');
});

test('it updates a book', function () {
    $mock = mocksBooks();

    $data = [
        'title' => $mock['books'][0]->title,
        'publish_date' => '1995-07-04',
        'authors' => [
            ['author_id' => $mock['author']->id]
        ],
    ];

    $response = $this->json('put', '/api/book/update/' . $mock['books'][0]->id, $data);
    $response->assertStatus(200);

    $responseData = $response->json();
    expect($responseData['id'])->toBe($mock['books'][0]->id);
    expect($responseData['publish_date'])->toBe('1995-07-04');
});

test('it deletes a book', function () {
    $mock = mocksBooks();

    $response = $this->json('delete', '/api/book/delete/' . $mock['books'][0]->id);
    $response->assertStatus(200);
});
