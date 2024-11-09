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
            $retryCount = 0;
            $maxRetries = 5; // You can set a limit for retries
            $waitTime = 10; // Wait time in seconds before retrying (can be dynamic based on response)

            while ($retryCount < $maxRetries) {
                $response = $this->client->post('https://api-inference.huggingface.co/models/gpt2', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                    'json' => [
                        'inputs' => $prompt,
                    ],
                ]);

                $responseData = json_decode($response->getBody()->getContents(), true);

                // Check if the response indicates that the model is still loading
                if (isset($responseData['error']) && strpos($responseData['error'], 'currently loading') !== false) {
                    $retryCount++;
                    $estimatedTime = $responseData['estimated_time'] ?? $waitTime;
                    sleep($estimatedTime); // Wait for the estimated time before retrying
                    continue;
                }

                // If no error, break out of the loop
                break;
            }

            // If retries exceeded, throw an error
            if ($retryCount >= $maxRetries) {
                throw new HuggingFaceClientException('Model loading took too long. Try again later.');
            }

            // Check if the response contains the necessary data
            if (isset($responseData[0]['generated_text'])) {
                return $responseData;
            }

            throw new HuggingFaceClientException('Text generation failed. No "generated_text" in response.');
        } catch (RequestException $e) {
            throw new HuggingFaceClientException('Request failed: ' . $e->getMessage());
        } catch (\Exception $e) {
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
            $retryCount = 0;
            $maxRetries = 5; // You can set a limit for retries
            $waitTime = 10; // Wait time in seconds before retrying (can be dynamic based on response)

            while ($retryCount < $maxRetries) {
                $response = $this->client->post('https://api-inference.huggingface.co/models/stabilityai/stable-diffusion-2', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                    'json' => [
                        'inputs' => $prompt,
                    ],
                ]);

                $responseData = json_decode($response->getBody()->getContents(), true);

                // Check if the response indicates that the model is still loading
                if (isset($responseData['error']) && strpos($responseData['error'], 'currently loading') !== false) {
                    $retryCount++;
                    $estimatedTime = $responseData['estimated_time'] ?? $waitTime;
                    sleep($estimatedTime); // Wait for the estimated time before retrying
                    continue;
                }

                // If no error, break out of the loop
                break;
            }

            // If retries exceeded, throw an error
            if ($retryCount >= $maxRetries) {
                throw new HuggingFaceClientException('Model loading took too long. Try again later.');
            }

            // Process the response (if model is ready)
            if ($response->getHeader('Content-Type')[0] === 'image/jpeg') {
                $imageStream = $response->getBody();
                $imagePath = storage_path('app/public/generated_image.jpg');
                file_put_contents($imagePath, $imageStream);

                return [
                    'image_path' => $imagePath, // Path to the saved image
                    'message' => 'Image generated successfully.'
                ];
            }

            throw new HuggingFaceClientException('Image generation failed. Unexpected response format.');
        } catch (RequestException $e) {
            throw new HuggingFaceClientException('Request failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            throw new HuggingFaceClientException('Unexpected error: ' . $e->getMessage());
        }
    }
}
