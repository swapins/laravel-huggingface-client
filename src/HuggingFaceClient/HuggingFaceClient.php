<?php

namespace swapinvidya\HuggingFaceClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use swapinvidya\HuggingFaceClient\Exceptions\HuggingFaceClientException;

class HuggingFaceClient
{
    protected $apiKey;
    protected $client;

    public function __construct($apiKey, Client $client = null)
    {
        $this->apiKey = $apiKey;
        $this->client = $client ?? new Client();
    }

    /**
     * Generate text from a given prompt.
     *
     * @param string $prompt
     * @return array
     * @throws HuggingFaceClientException
     */
    public function generateText(string $prompt)
    {
        try {
            $response = $this->client->post('https://api-inference.huggingface.co/models/gpt2', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
                'json' => [
                    'inputs' => $prompt,
                ],
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            // Check if the response contains the necessary data
            if (isset($responseData['generated_text'])) {
                return $responseData;
            }

            throw new HuggingFaceClientException('Text generation failed. No "generated_text" in response.');
        } catch (RequestException $e) {
            // Catching request exceptions and throwing a custom exception with the message
            throw new HuggingFaceClientException('Request failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Catching any other errors
            throw new HuggingFaceClientException('Unexpected error: ' . $e->getMessage());
        }
    }

    /**
     * Generate an image from a prompt.
     *
     * @param string $prompt
     * @return array
     * @throws HuggingFaceClientException
     */
    public function generateImage(string $prompt)
    {
        try {
            $response = $this->client->post('https://api-inference.huggingface.co/models/stabilityai/stable-diffusion-2', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
                'json' => [
                    'inputs' => $prompt,
                ],
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            // Check if the response contains an image URL
            if (isset($responseData['image_url'])) {
                return $responseData;
            }

            throw new HuggingFaceClientException('Image generation failed. No "image_url" in response.');
        } catch (RequestException $e) {
            // Catching request exceptions and throwing a custom exception with the message
            throw new HuggingFaceClientException('Request failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Catching any other errors
            throw new HuggingFaceClientException('Unexpected error: ' . $e->getMessage());
        }
    }
}
