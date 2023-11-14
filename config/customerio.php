<?php

return [
    /*
    |----------------------------------------------------------------------
    | CUSTOMER IO SITE ID
    |----------------------------------------------------------------------
    |
    | Here we need to define what will be the default from customer.io workspace
    |
    */
    'default' => env('CUSTOMER_IO_DEFAULT_WORKSPACE', 'default'),

    /*
    |----------------------------------------------------------------------
    | WORKSPACES DEFINITION
    |----------------------------------------------------------------------
    |
    | Here we can define multiple workspaces that you want to connect
    | and then you can choose between them
    |
    */
    'workspaces' => [
        'default' => [
            /*
            |----------------------------------------------------------------------
            | CUSTOMER IO SITE ID
            |----------------------------------------------------------------------
            |
            | Here we need to define site id generated from customer.io
            |
            */
            'site_id' => env('CUSTOMER_IO_SITE_ID', null),

            /*
            |----------------------------------------------------------------------
            | CUSTOMER IO API KEY
            |----------------------------------------------------------------------
            |
            | Here we need to define api key generated from customer.io
            |
            */
            'api_key' => env('CUSTOMER_IO_API_KEY', null),

            /*
            |----------------------------------------------------------------------
            | CUSTOMER IO API KEY
            |----------------------------------------------------------------------
            |
            | Here we need to define api key generated from customer.io
            |
            */
            'app_api_key' => env('CUSTOMER_IO_APP_API_KEY', null),
        ]
    ],
];
