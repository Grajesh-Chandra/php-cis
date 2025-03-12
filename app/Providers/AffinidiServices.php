<?php

namespace App\Providers;

use AffinidiTdk\Clients\CredentialIssuanceClient as CredentialClient;
use AffinidiTdk\Clients\IotaClient as IotaClient;
use Illuminate\Support\Facades\Log;
use AffinidiTdk\AuthProvider\AuthProvider;
use GuzzleHttp\Client;
use AffinidiTdk\Clients\WalletsClient;

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
    {
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
    }

    public static function SignCredentials($wallet_id, $unsignedCredentialParams)
    {
        Log::info('SignCredentials', ['wallet_id' => $wallet_id, 'unsignedCredentialParams' => $unsignedCredentialParams]);
        $authProvider = self::getProvider();
        $client = new Client();
        $url = 'https://apse1.api.affinidi.io/cwe/v1/wallets/' . $wallet_id . '/sign-credential';
        try {
            $response = $client->request('POST', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $authProvider->fetchProjectScopedToken(),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => $unsignedCredentialParams,
            ]);

            $result = json_decode($response->getBody(), true);

            return $result;
        } catch (\Exception $e) {
            Log::error('Error fetching credential status', ['error' => $e->getMessage()]);
            return ['error' => $e->getMessage()];
                    }
        }
    }
