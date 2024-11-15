<?php

return [


    'affinidi' => [
        'base_uri' => env('PROVIDER_ISSUER'),
        'client_id' => env('PROVIDER_CLIENT_ID'),
        'client_secret' => env('PROVIDER_CLIENT_SECRET'),
        'redirect' => '/login/affinidi/callback',
    ],

    'affinidi_tdk' => [
        'api_gateway_url' => env('API_GATEWAY_URL'),
        'token_endpoint' => env('TOKEN_ENDPOINT'),
        'project_Id' => env('PROJECT_ID'),
        'private_key' => env('PRIVATE_KEY'),
        'token_id' => env('TOKEN_ID'),
        'passphrase' => env('PASSPHRASE'),
        'key_id' => env('KEY_ID'),
        'vault_url' => env('VAULT_URL'),
    ],

    'affinidiCIS' => [
        'courseCredentialTypeId' => env('COURSE_CREDENTIAL_TYPE_ID'),
    ],

    'affinidi_iota' => [
        'config_id' => env('IOTA_CONFIG_ID'),
        'course_query_id' => env('IOTA_COURSE_CREDENTIAL_QUERY'),
    ],

];
