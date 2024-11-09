<?php
namespace swapinvidya\HuggingFaceClient;

use Illuminate\Support\ServiceProvider;

class HuggingFaceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/huggingface.php', 'huggingface');

        $this->app->singleton(HuggingFaceClient::class, function ($app) {
            $apiKey = config('huggingface.api_key');
            return new HuggingFaceClient($apiKey);
        });

        $this->commands([
            Commands\HuggingFaceGenerateTextCommand::class,
            Commands\HuggingFaceGenerateImageCommand::class,
        ]);
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/huggingface.php' => config_path('huggingface.php'),
            ], 'config');
        }
        $this->mergeConfigFrom(
            __DIR__.'/../../config/huggingface.php', 'huggingface'
        );
    }
}
