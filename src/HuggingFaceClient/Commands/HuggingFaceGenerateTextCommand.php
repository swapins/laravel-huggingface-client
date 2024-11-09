<?php

namespace swapinvidya\HuggingFaceClient\Commands;

use Illuminate\Console\Command;
use swapinvidya\HuggingFaceClient\HuggingFaceClient;

class HuggingFaceGenerateTextCommand extends Command
{
    protected $signature = 'huggingface:generate-text {prompt}';
    protected $description = 'Generate text from Hugging Face API using a prompt';

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
            $response = $this->huggingFaceClient->generateText($prompt);
            $this->info('Generated Text:');
            $this->line($response['generated_text']);
        } catch (HuggingFaceClientException $e) {
            $this->error($e->errorMessage());  // Display custom error message
        } catch (\Exception $e) {
            $this->error('An unexpected error occurred: ' . $e->getMessage());
        }
    }
}
