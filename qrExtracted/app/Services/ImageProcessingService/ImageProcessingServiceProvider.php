<?php

namespace App\Services\ImageProcessingService;

use Illuminate\Support\ServiceProvider;

class ImageProcessingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ImageProcessingService::class, function ($app) {
            return new ImageProcessingService();
        });
    }
}
