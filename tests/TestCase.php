<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function makeRequest(string $method, string $uri,  array $data = [], array $headers = []): TestResponse
    {
        $response = $this->withHeaders($headers);

        switch ($method) {
            case 'get':
                $response = $response->get($uri);
                break;
            case 'post':
                $response = $response->post($uri, $data);
                break;
            case 'put':
                $response = $response->put($uri, $data);
                break;
            case 'delete':
                $response = $response->delete($uri);
                break;
            default:
                throw new \InvalidArgumentException("Unsupported HTTP method: {$method}");
        }

        return $response;
    }
}
