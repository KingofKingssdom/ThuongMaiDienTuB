<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], 

    'allowed_origins' => [
        'https://thuong-mai-dien-tu-fe.vercel.app',
        
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], 

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, 

];