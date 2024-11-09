<?php

namespace swapinvidya\HuggingFaceClient\Commands;

use Illuminate\Console\Command;
use swapinvidya\HuggingFaceClient\HuggingFaceClient;

class HuggingFaceGenerateImageCommand extends Command
{
    protected $signature = 'huggingface:generate-image {prompt}';
    protected $description = 'Generate image from Hugging Face API using a prompt';

    protected $huggingFaceClient;

    public function __construct(HuggingFaceClient $huggingFaceClient)
    {
        parent::__construct();
        $this->huggingFaceClient = $huggingFaceClient;
    }

    public function handle()
    {
        $prompt = $this->argument('prompt');
        
        try {
            $response = $this->huggingFaceClient->generateImage($prompt);
            $this->info('Generated Image URL:');
            $this->line($response['image_url']);
        } catch (HuggingFaceClientException $e) {
            $this->error($e->errorMessage());  // Display custom error message
        } catch (\Exception $e) {
            $this->error('An unexpected error occurred: ' . $e->getMessage());
        }
    }
}
