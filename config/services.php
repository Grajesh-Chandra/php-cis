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
        'personalInformationCredentialTypeId' => env('PERSONAL_INFORMATION_CREDENTIAL_TYPE_ID'),
        'employmentCredentialTypeId' => env('EMPLOYMENT_CREDENTIAL_TYPE_ID'),
        'educationCredentialTypeId' => env('EDUCATION_CREDENTIAL_TYPE_ID'),
        'addressCredentialTypeId' => env('ADDRESS_CREDENTIAL_TYPE_ID'),
        'configurationId' => env('CONFIGURATION_ID'),
        'avvanzDigitalCredentialTypeId' => env('AVVANZ_DIGITAL_CREDENTIAL_ID'),
    ],

    'affinidi_iota' => [
        'config_id' => env('IOTA_CONFIG_ID'),
        'avvanz_query_id' => env('IOTA_AVVANZ_CREDENTIAL_QUERY'),
    ],

    'affinidi_sign_credentials' => [
        'walletId' => env('WALLET_ID'),
        'holderDID' => env('HOLDER_DID'),
        'pdf_signature_json' => env('PDF_SIGNATURE_JSON'),
        'pdf_signature_jsonld' => env('PDF_SIGNATURE_JSONLD'),
        'pdf_signature_type_id' => env('PDF_SIGNATURE_TYPE_ID'),
    ],

];
