<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [
    'proxies' => explode(',', env('TRUSTED_PROXIES', '*')),
];
