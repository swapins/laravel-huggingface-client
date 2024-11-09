<?php

namespace tests\Feature;

use Tests\TestCase;
use swapinvidya\HuggingFaceClient\HuggingFaceClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HuggingFaceClientTest extends TestCase
{
    public function test_generate_text_success()
    {
        $mockResponse = ['generated_text' => 'Hello, World!'];
        $client = $this->createMock(Client::class);
        $client->method('post')
            ->willReturnSelf();
        $client->method('getBody')
            ->willReturn(json_encode($mockResponse));

        $huggingFaceClient = new HuggingFaceClient('mock-api-key', $client);

        $response = $huggingFaceClient->generateText('Hello');
        $this->assertEquals('Hello, World!', $response['generated_text']);
    }

    public function test_generate_image_success()
    {
        $mockResponse = ['image_url' => 'http://example.com/image.png'];
        $client = $this->createMock(Client::class);
        $client->method('post')
            ->willReturnSelf();
        $client->method('getBody')
            ->willReturn(json_encode($mockResponse));

        $huggingFaceClient = new HuggingFaceClient('mock-api-key', $client);

        $response = $huggingFaceClient->generateImage('A beautiful sunset');
        $this->assertEquals('http://example.com/image.png', $response['image_url']);
    }
}
