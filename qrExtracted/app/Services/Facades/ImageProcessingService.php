<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class ImageProcessingService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\ImageProcessingService\ImageProcessingService::class;
    }
}
