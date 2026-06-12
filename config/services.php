<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'refresh_token' => env('GOOGLE_REFRESH_TOKEN'),
    ],

    'fifa' => [
        'base_url' => env('FIFA_RESULTS_BASE_URL', 'https://api.fifa.com/api/v3'),
        'competition_id' => env('FIFA_WORLD_CUP_COMPETITION_ID', '17'),
        'season_id' => env('FIFA_WORLD_CUP_SEASON_ID', '285023'),
        'user_agent' => env('FIFA_RESULTS_USER_AGENT', 'The Real Deal World Cup Pool/1.0'),
        'verify_ssl' => env('FIFA_RESULTS_VERIFY_SSL', true),
        'cache_store' => env('FIFA_RESULTS_CACHE_STORE', 'file'),
        'cache_ttl_seconds' => env('FIFA_RESULTS_CACHE_TTL_SECONDS', 300),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
