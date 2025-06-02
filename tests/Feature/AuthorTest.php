<?php

namespace Tests\Feature;

use App\Models\Authors;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorTest extends TestCase
{

    use RefreshDatabase;

    public function testGetAuthor(): void
    {
        $mock = $this->mocks();
        
        $response = $this->makeRequest('get', '/api/author/index');
        $content = $response->getContent();
        $responseData = json_decode($content, true);

        $response->assertStatus(200);
        $this->assertEquals(3, count($responseData));
    }

    public function testGetAuthorById(): void
    {
        $mock = $this->mocks();
        
        
        $response = $this->makeRequest('get', '/api/author/show/' . $mock['author'][0]->id);
        $content = $response->getContent();
        $responseData = json_decode($content, true);

        $response->assertStatus(200);
        $this->assertEquals($mock['author'][0]->id, $responseData['id']);
    }

    public function testCreateAuthor(): void
    {
        $mock = $this->mocks();
        
        $data =  [
            'name' => 'teste',
            'birth_date' => '1995-07-04'
        ];
        
        $response = $this->makeRequest('post', '/api/author/store', $data);
        $content = $response->getContent();
        $responseData = json_decode($content, true);
        $response->assertStatus(200);
        $this->assertEquals('teste', $responseData['name']);
    }


    public function testUpdateAuthor(): void
    {
        $mock = $this->mocks();
        
        $data = [
            'name' => $mock['author'][0]->name,
            'birth_date' => '1995-07-04'
        ];

        $response = $this->makeRequest('put', '/api/author/update/' . $mock['author'][0]->id, $data);
        $content = $response->getContent();
        $responseData = json_decode($content, true);

        $response->assertStatus(200);
        $this->assertEquals($responseData['id'], $mock['author'][0]->id);
        $this->assertEquals($responseData['birth_date'], '1995-07-04');
    }

    public function testDeleteAuthor(): void
    {
        $mock = $this->mocks();
        

        $response = $this->makeRequest('delete', '/api/author/delete/' . $mock['author'][0]->id);
        $content = $response->getContent();
        $responseData = json_decode($content, true);

        $response->assertStatus(200);
    }

    protected function mocks() 
    {
        $author = Authors::factory(3)->create();

        $mock = [
            'author' => $author,
        ];

        return $mock;
    }
}