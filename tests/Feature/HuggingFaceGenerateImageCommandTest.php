<?php

namespace tests\Feature;

use Illuminate\Support\Facades\Artisan;
use swapinvidya\HuggingFaceClient\HuggingFaceClient;
use Tests\TestCase;

class HuggingFaceGenerateImageCommandTest extends TestCase
{
    public function test_generate_image_command()
    {
        // Simulate the response for the image generation
        $this->mock(HuggingFaceClient::class, function ($mock) {
            $mock->shouldReceive('generateImage')
                 ->once()
                 ->with('A beautiful sunset')
                 ->andReturn(['image_url' => 'http://example.com/image.png']);
        });

        // Run the Artisan command
        Artisan::call('huggingface:generate-image', ['prompt' => 'A beautiful sunset']);
        
        // Assert the output contains the image URL
        $this->assertStringContainsString('http://example.com/image.png', Artisan::output());
    }
}
