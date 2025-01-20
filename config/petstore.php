<?php

return [
    'url' => env('PETSTORE_API_URL', 'https://petstore.swagger.io/v2/'),
    'timeout' => env('PETSTORE_API_TIMEOUT', 3),
    'connect_timeout' => env('PETSTORE_API_CONNECT_TIMEOUT', 2),
    'retries' => env('PETSTORE_API_RETRIES', 3),
    'retry_delay' => env('PETSTORE_API_RETRY_DELAY', 300),
    'api_key' => env('PETSTORE_API_KEY', null),
];
