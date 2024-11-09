
# Laravel Hugging Face Client

**swapinvidya/laravel-huggingface-client** is a Laravel package that simplifies integration with the [Hugging Face API](https://huggingface.co/docs/api-inference). This package provides an easy way to interact with models for text generation, image creation, and other AI-powered features.

## Features

- **Text Generation**: Generate text using models like `gpt2` and `gpt-neo`.
- **Image Generation**: Create images based on text prompts using models such as `stable-diffusion`.
- **Custom Model Completions**: Use any available Hugging Face model for specialized tasks.
- **Seamless Integration**: Built for Laravel, with easy dependency injection.

## Installation

### Step 1: Install via Composer

Run the following command in your Laravel project directory:

```bash
composer require swapinvidya/laravel-huggingface-client
```

### Step 2: Publish Configuration

Publish the configuration file to customize your API key and other options:

```bash
php artisan vendor:publish --provider="Swapinvidya\HuggingFaceClient\HuggingFaceServiceProvider"
```

### Step 3: Set Up API Key

Add your Hugging Face API key to the `.env` file:

```env
HUGGINGFACE_API_KEY=your_huggingface_api_key
```

## Configuration

The configuration file will be published to `config/huggingface.php`. You can customize your API key and other settings there.

```php
return [
    'api_key' => env('HUGGINGFACE_API_KEY'),
    'base_uri' => 'https://api-inference.huggingface.co/',
];
```

## Usage

Inject the `HuggingFaceClient` in your controllers or services to use its capabilities.

### Example: Generate Text

```php
use Swapinvidya\HuggingFaceClient\HuggingFaceClient;

public function generateText(HuggingFaceClient $huggingFaceClient)
{
    $response = $huggingFaceClient->generateText('gpt2', 'Write a short story about a hero.');
    return response()->json($response);
}
```

### Example: Generate Image

```php
public function generateImage(HuggingFaceClient $huggingFaceClient)
{
    $response = $huggingFaceClient->generateImage('stable-diffusion-v1', 'A futuristic city with flying cars.');
    return response()->json($response);
}
```

### Example: Custom Model Completion

```php
public function generateCompletion(HuggingFaceClient $huggingFaceClient)
{
    $params = [
        'inputs' => 'Explain the theory of relativity in simple terms.',
        'parameters' => [
            'temperature' => 0.7,
            'max_new_tokens' => 200,
        ],
    ];
    $response = $huggingFaceClient->generateCompletion('gpt-neo', $params);
    return response()->json($response);
}
```

## Available Methods

### `generateText($model, $input)`
Generates text output using the specified model.

- **`$model`**: The model to use (e.g., `gpt2`, `gpt-neo`).
- **`$input`**: The text input/prompt for the model.

### `generateImage($model, $input)`
Creates an image based on a text prompt.

- **`$model`**: The image generation model (e.g., `stable-diffusion`).
- **`$input`**: The text prompt describing the image.

### `generateCompletion($model, $params)`
Generates a completion response with custom parameters.

- **`$model`**: The model to use (e.g., `gpt-neo`, `opt`).
- **`$params`**: Array of parameters including `inputs` and optional model settings like `temperature` and `max_new_tokens`.

## Error Handling

The client will return error information in the response if a request fails:

```php
$response = $huggingFaceClient->generateText('gpt2', 'Hello world');

if (isset($response['error'])) {
    // Handle the error
    return response()->json(['error' => $response['error']], 500);
}

return response()->json($response);
```

## Testing

To test your package locally, you can link it to a Laravel project using:

```bash
composer config repositories.local '{"type": "path", "url": "../path/to/laravel-huggingface-client"}'
composer require swapinvidya/laravel-huggingface-client:@dev
```

## Contributing

Feel free to open issues or submit pull requests for improvements and new features.

## License

This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

*Developed by [swapinvidya](https://github.com/swapinvidya)*
```