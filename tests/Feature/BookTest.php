<?php

namespace Tests\Feature;

use App\Models\Authors;
use App\Models\Books;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{

    use RefreshDatabase;

    public function testGetBook(): void
    {
        $mock = $this->mocks();
        
        $response = $this->makeRequest('get', '/api/book/index');
        $content = $response->getContent();
        $responseData = json_decode($content, true);

        $response->assertStatus(200);
        $this->assertEquals(3, count($responseData['data']));
    }

    public function testGetBookById(): void
    {
        $mock = $this->mocks();
        
        $response = $this->makeRequest('get', '/api/book/show/' . $mock['books'][0]->id);
        $content = $response->getContent();
        $responseData = json_decode($content, true);

        $response->assertStatus(200);
        $this->assertEquals($mock['books'][0]->id, $responseData['id']);
    }

    public function testCreateBook(): void
    {
        $mock = $this->mocks();
        $data =   [
            'title' => 'teste',
            'publish_date' => '1995-04-08',
            'authors' => [
                ["author_id" => $mock['author']->id]
            ]
        ];
        
        $response = $this->makeRequest('post', '/api/book/store', $data);
        $content = $response->getContent();
        $responseData = json_decode($content, true);
        $response->assertStatus(200);
        $this->assertEquals('teste', $responseData['title']);
    }

    public function testUpdateBook(): void
    {
        $mock = $this->mocks();
        $data = [
            'title' => $mock['books'][0]->title,
            'publish_date' => '1995-07-04',
            'authors' => [
                ["author_id" => $mock['author']->id]
            ]
        ];

        $response = $this->makeRequest('put', '/api/book/update/' . $mock['books'][0]->id, $data);
        $content = $response->getContent();
        $responseData = json_decode($content, true);

        $response->assertStatus(200);
        $this->assertEquals($responseData['id'], $mock['books'][0]->id);
        $this->assertEquals($responseData['publish_date'], '1995-07-04');
    }

    public function testDeleteBook(): void
    {
        $mock = $this->mocks();

        $response = $this->makeRequest('delete', '/api/book/delete/' . $mock['books'][0]->id);
        $content = $response->getContent();
        $responseData = json_decode($content, true);

        $response->assertStatus(200);
    }

    protected function mocks() 
    {
        $author = Authors::factory()->create();
        $books = Books::factory(3)->create();

        foreach($books as $book) {
            $book->authors()->attach($author->id);   
        }

        $mock = [
            'author' => $author,
            'books' => $books,
        ];

        return $mock;
    }
}
