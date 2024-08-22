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

    'supportsCredentials' => true,
'allowedOrigins' => ['*'],
'allowedOriginsPatterns' => [],
'allowedHeaders' => ['*'],
'allowedMethods' => ['*'],
'exposedHeaders' => [],
'maxAge' => 0,
];
