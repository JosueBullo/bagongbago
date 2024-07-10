<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    // Specifies the paths that should be accessible cross-origin; 
    // all routes under 'api/' and the 'sanctum/csrf-cookie' route are accessible.
    'paths' => ['api/*', 'sanctum/csrf-cookie'], 

    'allowed_methods' => ['*'],

    // Specifies the origins that are allowed to access the resources; only requests from 
    // 'http://localhost:8080' are allowed.
    'allowed_origins' => ['http://localhost:8080'], 

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Allows the browser to include credentials like cookies or HTTP authentication headers 
    // in the request, enabling proper authentication handling.
    'supports_credentials' => true, // Set this to true, 

];
