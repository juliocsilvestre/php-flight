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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'openweather' => [
        'api_key' => env('OPENWEATHER_API_KEY'),
        'api_url' => env('OPENWEATHER_API_URL', 'https://api.openweathermap.org/data/2.5'),
    ],

    'flight' => [
        'render_3d_enabled' => env('FLIGHT_3D_RENDER_ENABLED', true),
        'high_season_months' => env('HIGH_SEASON_MONTHS', '6,7,8,12,1'),
        'peak_hours' => env('PEAK_HOURS', '6,7,8,17,18,19,20'),
    ],

];
