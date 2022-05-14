<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public runtime environment for web app
    |--------------------------------------------------------------------------
    |
    | These values will be provided to the web app via the web-init endpoint.
    |
    */

    'app_env' => env('APP_ENV', 'production'),

    'app_debug' => env('APP_DEBUG', false),

    'app_url' => env('APP_URL', 'http://localhost'),

    'sentry' => [
        'dsn' => env('SENTRY_VUE_DSN', env('SENTRY_DSN')),

        'environment' => env('SENTRY_ENVIRONMENT'),

        'traces_sample_rate' => (float) env('SENTRY_VUE_TRACES_SAMPLE_RATE', 0.0),

        'track_components' => env('SENTRY_VUE_TRACK_COMPONENTS', false),
    ],

    'ga_tracking_id' => env('GA_TRACKING_ID'),

];
