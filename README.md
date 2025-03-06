# Affinidi Trust Network Implementation

This is a template that showcases how you can enable your applications to issue credentials to users and store them in their Affinidi Vault. It accomplishes this through Affinidi Vault using the [OpenID for Verifiable Credential Issuance](https://openid.net/specs/openid-4-verifiable-credential-issuance-1_0.html) and [OpenID for Verifiable Presentations specification.](https://openid.net/specs/openid-4-verifiable-presentations-1_0.html) specification.

First, copy `.env.example` to `.env`:

```
cp .env.example .env
```

## Install

Install the required dependencies:

```
composer install
```

## Affinidi Configurations

1. Click here to [Set up your environment variables for Affinidi Login configuration](#set-up-your-affinidi-login-configuration)
2. Click here to [Set up your Personnel Access Token to interact with Affinidi services](./docs/create-pat.md)
3. Click here to [Set up your Credential Issuance Configuration](./docs/cis-configuration.md)
4. Click here to [Set up your environment variables for Affinidi Iota configuration](#set-up-your-affinidi-iota-configuration)

Update `.env` file with below values from Personal Access Token

```
PROJECT_ID=""
KEY_ID="" # optional. required if different key_id is used or else Token_Id=Key_Id
TOKEN_ID=""
PASSPHRASE="" # Optional. Required if private key is encrypted
PRIVATE_KEY=""
```

Update `.env` file with below values from Credential Issuance configuration

```
PERSONAL_INFORMATION_CREDENTIAL_TYPE_ID="TPersonalInformationVerificationV1R0"
ADDRESS_CREDENTIAL_TYPE_ID="TAddressVerificationV1R0"
EDUCATION_CREDENTIAL_TYPE_ID="TEducationVerificationV1R0"
EMPLOYMENT_CREDENTIAL_TYPE_ID="TEmploymentVerificationV1R1"
```

## Run

Start server with:

```
php artisan serve
```

Then visit: http://localhost:8010/cis


## Setup python for executing the python script

1. Install python

```
brew install python

```

2. Create virtual environment : search for virtual environment in visual studio for " Python: create envioronment"

```
Create via .venv
```

3. Close your terminal and open a new terminal, it will have (.venv) in it.

4. Install python library

```
pip install pypdf

```


## Set up your Affinidi Login configuration

1. Follow [this guide](./docs/setup-login-config.md) to set up your login configuration with callback URL as `http://localhost:8010/login/affinidi/callback`

2. Copy your **Client ID**, **Client Secret** and **Issuer** from your login configuration and paste them into your `.env` file:

```ini
PROVIDER_CLIENT_ID="<CLIENT_ID>"
PROVIDER_CLIENT_SECRET="<CLIENT_SECRET>"
PROVIDER_ISSUER="<ISSUER>"
```

## Set up your Affinidi Iota configuration

1. Follow [this guide](./docs/setup-iota-config.md) to set up your iota configuration

2. Copy your **Configuration ID** and **Query ID** for address, and paste them into your `.env` file:

```ini
IOTA_CONFIG_ID="Iota configuration id"
IOTA_AVVANZ_CREDENTIAL_QUERY="Query ID of VC Request"
```

## How to Use Affinidi TDK for PHP

Affinidi Trust Development Kit (Affinidi TDK)
More details [here](https://github.com/affinidi/affinidi-tdk-php)

1. Install the Affinidi TDK PHP package using composer

```
composer require affinidi-tdk/affinidi-tdk-php
```

2. Create Auth Provider using the Personal Access Token, which is used to generate Project Scope Token for making API calls

```
use AffinidiTdk\AuthProvider\AuthProvider;

$params = [
  'privateKey' => "",
  'keyId' => '',
  'passphrase' => '',
  'projectId' => '',
  'tokenId' => ''
];

$authProvider = new AuthProvider($params);
```

3. Call any TDK Client methods like ListWallets or Start Issuance etc..

e.g. To get Wallets List

```
use AffinidiTdk\Clients\WalletsClient;
...
...
$tokenCallback = [$authProvider, 'fetchProjectScopedToken'];
$configCwe = WalletsClient\Configuration::getDefaultConfiguration()->setApiKey('authorization', '', $tokenCallback);

$apiInstanceCwe = new WalletsClient\Api\WalletApi(
    new GuzzleHttp\Client(),
    $configCwe
);

$resultCwe = $apiInstanceCwe->listWallets();

$resultCweJson = json_decode($resultCwe, true);

print_r(count($resultCweJson['wallets']));
```

e.g. Issue a Verifiable Credentials

```
use AffinidiTdk\Clients\CredentialIssuanceClient as CredentialClient;
...
...
$tokenCallback = [$authProvider, 'fetchProjectScopedToken'];

$configClient = CredentialClient\Configuration::getDefaultConfiguration()->setApiKey('authorization', '', $tokenCallback);

$apiInstance = new CredentialClient\Api\IssuanceApi(
    new \GuzzleHttp\Client(),
    $configClient
);

$project_id = "";
$start_issuance_input= [
    'data' => [
        "credentialTypeId" => "ContactDetails",
        "credentialData" => [
            "name" => [
                "givenName" => "Paramesh",
                "familyName" => "Kamarthi",
            ],
            "email" => "paramesh.k@affinidi.com",
            "gender" => "male"
        ]
    ],
    'claimMode' => "TX_CODE"
];

$result = $apiInstance->startIssuance($project_id, $start_issuance_input);

$resultJson = json_decode($result, true);

print_r(count($resultJson));
```

## Read More

Explore our [documentation](https://docs.affinidi.com/docs/) and [labs](https://docs.affinidi.com/labs/) to learn more about integrating Affinidi Login with Affinidi Vault.

## Telemetry

Affinidi collects usage data to improve our products and services. For information on what data we collect and how we use your data, please refer to our [Privacy Notice](https://www.affinidi.com/privacy-notice).

## Feedback, Support, and Community

[Click here](https://github.com/affinidi/reference-app-affinidi-vault/issues) to create a ticket and we will get on it right away. If you are facing technical or other issues, you can [Contact Support](https://share.hsforms.com/1i-4HKZRXSsmENzXtPdIG4g8oa2v).

## FAQ

### What can I develop?

You are only limited by your imagination! Affinidi Reference Applications are a toolbox with which you can build software apps for personal or commercial use.

### Is there anything I should not develop?

We only provide the tools - how you use them is largely up to you. We have no control over what you develop with our tools - but please use our tools responsibly!

We hope that you would not develop anything that contravenes any applicable laws or regulations. Your projects should also not infringe on Affinidi’s or any third party’s intellectual property (for instance, misusing other parties’ data, code, logos, etc).

### What responsibilities do I have to my end-users?

Please ensure that you have in place your own terms and conditions, privacy policies, and other safeguards to ensure that the projects you build are secure for your end users.

If you are processing personal data, please protect the privacy and other legal rights of your end-users and store their personal or sensitive information securely.

Some of our components would also require you to incorporate our end-user notices into your terms and conditions.

### Are Affinidi Reference Applications free for use?

Affinidi Reference Applications are free, so come onboard and experiment with our tools and see what you can build! We may bill for certain components in the future, but we will inform you beforehand.

### Do I need to provide you with anything?

From time to time, we may request certain information from you to ensure that you are complying with the [Terms and Conditions](https://www.affinidi.com/terms-conditions).

### Can I share my developer’s account with others?

When you create a developer’s account with us, we will issue you your private login credentials. Please do not share this with anyone else, as you would be responsible for activities that happen under your account. If you have friends who are interested, ask them to sign up – let's build together!

## _Disclaimer_

_Please note that this FAQ is provided for informational purposes only and is not to be considered a legal document. For the legal terms and conditions governing your use of the Affinidi Reference Applications, please refer to our [Terms and Conditions](https://www.affinidi.com/terms-conditions)._
