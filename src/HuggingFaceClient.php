<?php

namespace YourVendor\HuggingFaceClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HuggingFaceClient
{
    protected $client;
    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client([
            'base_uri' => 'https://api-inference.huggingface.co/',
            'headers' => [
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function generateText($model, $input)
    {
        return $this->sendRequest("models/{$model}", ['inputs' => $input]);
    }

    public function generateImage($model, $input)
    {
        return $this->sendRequest("models/{$model}", ['inputs' => $input]);
    }

    public function generateCompletion($model, $params)
    {
        return $this->sendRequest("models/{$model}", $params);
    }

    protected function sendRequest($endpoint, $body)
    {
        try {
            $response = $this->client->post($endpoint, [
                'body' => json_encode($body),
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return [
                'error' => $e->getMessage(),
                'status' => $e->getCode(),
            ];
        }
    }
}
