<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | QR Code settings
    |--------------------------------------------------------------------------
    |
    | These settings control how the QR Code should look like
    |
    */

    'url' => env('QR_BASE_URL', env('APP_URL')),
    'logo' => [
        'show' => env('QR_LOGO_SHOW', true),
        'path' => env('QR_LOGO_PATH', resource_path('img/asta-logo.PNG')),
    ],
    'subtitle' => [
        'show' => env('QR_SUBTITLE_SHOW', true),
    ],
];
