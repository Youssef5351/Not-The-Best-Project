<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Options
    |--------------------------------------------------------------------------
    |
    | The allowed_methods and allowed_origins options can accept any
    | string or array, the allowed_headers option must be an array.
    |
    */
    'paths' => ['*/api', 'sanctum/csrf-cookie','api/signup'],
    'allowed_methods' => ['POST', 'GET', 'OPTIONS', 'PUT', 'PATCH', 'DELETE'],
    'allowed_origins' => ['https://vanilla2-gray.vercel.app'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
