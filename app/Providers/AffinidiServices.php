<?php

namespace App\Providers;
use AffinidiTdk\Clients\CredentialIssuanceClient as CredentialClient;
use AffinidiTdk\Clients\IotaClient as IotaClient;
use Illuminate\Support\Facades\Log;
use AffinidiTdk\AuthProvider\AuthProvider;

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
}