<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [
    'proxies' => ($val = (explode(',', env('TRUSTED_PROXIES', '*')))) === ['*'] ? '*' : $val,
];
