<?php

declare(strict_types=1);

return [
    'facebook' => [
        'oauth_url' => env('FACEBOOK_OAUTH_URL'),
        'api_url' => env('FACEBOOK_API_URL'),
        'access_token_url' => env('FACEBOOK_ACCESS_TOKEN_URL'),
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'redirect_uri' => env('FACEBOOK_REDIRECT_URI'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'fields_to_request' => env('FACEBOOK_FIELDS_TO_REQUEST')
    ]
];