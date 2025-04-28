<?php

namespace App\Providers;

use AffinidiTdk\Clients\CredentialIssuanceClient as CredentialClient;
use AffinidiTdk\Clients\IotaClient as IotaClient;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use AffinidiTdk\AuthProvider\AuthProvider;
use AffinidiTdk\Clients\CredentialIssuanceClient\Api\CredentialsApi;
use AffinidiTdk\Clients\WalletsClient;
use AffinidiTdk\Clients\CredentialVerificationClient;
use AffinidiTdk\Clients\CredentialVerificationClient\Configuration as VerificationClientConfiguration;

use function Laravel\Prompts\error;

class AffinidiServices
{
    public static function getProvider(): AuthProvider
    {
        return app(AuthProvider::class);
    }

    public static function IssuanceStart($project_id, $start_issuance_input)
    {
        $authProvider = self::getProvider();

        $tokenCallback = [$authProvider, 'fetchProjectScopedToken'];

        $configClient = CredentialClient\Configuration::getDefaultConfiguration()->setApiKey('authorization', '', $tokenCallback);

        $apiInstance = new CredentialClient\Api\IssuanceApi(
            new \GuzzleHttp\Client(),
            $configClient
        );

        $result = $apiInstance->startIssuance($project_id, $start_issuance_input);

        $resultJson = json_decode($result, true);

        return $resultJson;
    }

    public static function IotaStart($initiate_data_sharing_request_input)
    {
        $authProvider = self::getProvider();

        $tokenCallback = [$authProvider, 'fetchProjectScopedToken'];

        $configClient = IotaClient\Configuration::getDefaultConfiguration()->setApiKey('authorization', '', $tokenCallback);

        $apiInstance = new IotaClient\Api\IotaApi(
            new \GuzzleHttp\Client(),
            $configClient
        );

        $result = $apiInstance->initiateDataSharingRequest($initiate_data_sharing_request_input);

        $resultJson = json_decode($result, true);

        return $resultJson;
    }

    public static function IotaCallback($fetch_iotavp_response_input)
    {
        $authProvider = self::getProvider();

        $tokenCallback = [$authProvider, 'fetchProjectScopedToken'];

        $configClient = IotaClient\Configuration::getDefaultConfiguration()->setApiKey('authorization', '', $tokenCallback);

        $apiInstance = new IotaClient\Api\IotaApi(
            new \GuzzleHttp\Client(),
            $configClient
        );

        $result = $apiInstance->fetchIotaVpResponse($fetch_iotavp_response_input);

        $resultJson = json_decode($result, true);

        return $resultJson;
    }

    public static function IssuedCredential($project_id, $configuration_id, $issuance_id) // Assuming parameters are project_id, configuration_id, issuance_id
    {
        Log::info('IssuedCredential', ['project_id' => $project_id, 'configuration_id' => $configuration_id, 'issuance_id' => $issuance_id]);
        $authProvider = self::getProvider();
        $client = new Client();
        $url = 'https://apse1.api.affinidi.io/cis/v1/' . $project_id . '/configurations/' . $configuration_id . '/issuances/' . $issuance_id . '/credentials'; // Corrected URL with $configuration_id
        try {
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $authProvider->fetchProjectScopedToken(),
                    'Accept' => 'application/json',
                ],
            ]);

            $result = json_decode($response->getBody(), true);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error fetching credential status', ['error' => $e->getMessage()]);
            return ['error' => $e->getMessage()];
        }
    }

    public static function CredentialStatus($project_id, $configuration_id, $issuance_id)
    { {
            Log::info('IssuedCredential', ['project_id' => $project_id, 'configuration_id' => $configuration_id, 'issuance_id' => $issuance_id]);
            $authProvider = self::getProvider();
            $client = new Client();
            $url = 'https://apse1.api.affinidi.io/cis/v1/' . $project_id . '/configurations/' . $configuration_id . '/issuances/' . $issuance_id . '/credentials'; // Corrected URL with $configuration_id
            try {
                $response = $client->request('GET', $url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $authProvider->fetchProjectScopedToken(),
                        'Accept' => 'application/json',
                    ],
                ]);

                $result = json_decode($response->getBody(), true);
                return $result;
            } catch (\Exception $e) {
                Log::error('Error fetching credential status', ['error' => $e->getMessage()]);
                return ['error' => $e->getMessage()];
            }
        }
    }


    public static function SignCredentials($wallet_id, $unsignedCredentialParams)
    {
        Log::info('SignCredentials', ['wallet_id' => $wallet_id, 'unsignedCredentialParams' => $unsignedCredentialParams]);
        $authProvider = self::getProvider();
        $tokenCallback = [$authProvider, 'fetchProjectScopedToken'];
        $configClient = WalletsClient\Configuration::getDefaultConfiguration()->setApiKey('authorization', '', $tokenCallback);
        $api = new WalletsClient\Api\WalletApi(
            new \GuzzleHttp\Client(),
            $configClient
        );
        $result = $api->signCredential($wallet_id, $unsignedCredentialParams);
        $resultJson = json_decode($result, true);
        Log::info('SignCredentials', ['resultJson' => $resultJson]);
        return $resultJson;
    }

    public static function Verification($verify_credential_input)
    {
        Log::info('Verification', ['verify_credential_input' => $verify_credential_input]);
        $authProvider = self::getProvider();
        $tokenCallback = [$authProvider, 'fetchProjectScopedToken'];
        $configClient = VerificationClientConfiguration::getDefaultConfiguration()->setApiKey('authorization', '', $tokenCallback);
        $apiInstance = new CredentialVerificationClient\Api\DefaultApi(
            new \GuzzleHttp\Client(),
            $configClient
        );

        $result = $apiInstance->verifyCredentials($verify_credential_input);

        $resultJson = json_decode($result, true);

        return $resultJson;
    }

    public static function revokeCredentials($project_id, $configuration_id, $revoke_credential_input) // Corrected method name
    {
        Log::info('revokeCredentials', ['project_Id' => $project_id, 'configuration_id' => $configuration_id, 'revoke_credential_input' => $revoke_credential_input]);

        $authProvider = self::getProvider();
        $tokenCallback = [$authProvider, 'fetchProjectScopedToken'];
        $configClient = CredentialClient\Configuration::getDefaultConfiguration()->setApiKey('authorization', '', $tokenCallback);
        $api = new CredentialClient\Api\DefaultApi(
            new \GuzzleHttp\Client(),
            $configClient
        );

        $response = $api->changeCredentialStatus($project_id, $configuration_id, $revoke_credential_input);
        Log::info('Revoke response', ['response' => $response]);

        // Decode the response
        $resultJson = json_decode($response, true);
        return $resultJson;
    }

    public static function listIssuanceDataRecords($project_id, $configuration_id, $issuance_id)
    {
        $authProvider = self::getProvider();
        $tokenCallback = [$authProvider, 'fetchProjectScopedToken'];
        $configClient = CredentialClient\Configuration::getDefaultConfiguration()->setApiKey('authorization', '', $tokenCallback);
        $apiInstance = new CredentialClient\Api\DefaultApi(
            new \GuzzleHttp\Client(),
            $configClient
        );

        $result = $apiInstance->listIssuanceDataRecords($project_id, $configuration_id); // Added $configuration_id

        $resultJson = json_decode($result, true);
        Log::info('listIssuanceDataRecords', ['resultJson' => $resultJson]);

        return $resultJson;
    }
}
