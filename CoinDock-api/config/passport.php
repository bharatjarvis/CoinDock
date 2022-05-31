<?php

return [
    /*
     * Path for the public and private keys.
     *
     * Laravel's storage path is the default.
     *
     * @var string
     */
    'keys_path' => storage_path(),

    /*
     * Token expiry in minutes.
     *
     * @var int
     */
    'tokens_expire_in' => env('PASSPORT_TOKENS_EXPIRE_IN', 5),

    /*
     * Personal access token expiry in days.
     *
     * @var int
     */
    'personal_access_tokens_expire_in' => 7,

    /*
     * Refresh token expiry in minutes.
     *
     * @var int
     */
    'refresh_tokens_expire_in' => env('PASSPORT_REFRESH_TOKENS_EXPIRE_IN', 5),

    /*
     * All available scopes.
     *
     * Authorize screen will say "This application will be able to:".
     *
     * @var array
     */
    'scopes' => [
        'web-app-user' => 'Access and modify your CoinDock application',
    ],

    /*
     * Config for the web app client.
     *
     * @var array
     */
    'client' => [
        'id' => env('CLIENT_ID'),
        'secret' => env('CLIENT_SECRET'),
        'scopes' => ['web-app-user'],
    ],

];