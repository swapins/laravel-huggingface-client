<?php

namespace tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class HuggingFaceGenerateTextCommandTest extends TestCase
{
    public function test_generate_text_command()
    {
        // Simulate the response for text generation
        $this->mock(HuggingFaceClient::class, function ($mock) {
            $mock->shouldReceive('generateText')
                 ->once()
                 ->with('Hello')
                 ->andReturn(['generated_text' => 'Hello, World!']);
        });

        // Run the Artisan command
        Artisan::call('huggingface:generate-text', ['prompt' => 'Hello']);
        
        // Assert the output contains the generated text
        $this->assertStringContainsString('Hello, World!', Artisan::output());
    }
}
