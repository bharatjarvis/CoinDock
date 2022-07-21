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

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Content-Type',
        'X-Access-Token',
        'X-CSRF-Token',
        'X-Requested-With',
        'Origin',
        'Authorization',
        'Refresh-Token',
    ],

    'exposed_headers' => [
        'Cache-Control',
        'Content-Language',
        'Content-Type',
        'Expires-In',
        'Last-Modified',
        'Access-Token',
        'Reset-Token',
        'Refresh-Token',
        'Content-Disposition',
        'Redirect-Location',
        'Redirect-Session-Cookie',
        'Redirect-Session-Cookie-Domain',
        'Redirect-Session-Cookie-Name',
    ],

    'max_age' => 0,

    'supports_credentials' => false,

];