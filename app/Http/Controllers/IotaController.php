<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use App\Providers\AffinidiServices;

class IotaController extends Controller
{
    public function start(Request $request)
    {
        try {

            $configurationId = $request->input('configurationId');
            $queryId = $request->input('queryId');
            $redirectUri = $request->input('redirectUri');
            $nonce = $request->input('nonce');

            $response = AffinidiServices::IotaStart([
                "configurationId" => $configurationId,
                "mode" => "redirect",
                "queryId" => $queryId,
                "correlationId" => Uuid::uuid4()->toString(),
                "nonce" => $nonce,
                "redirectUri" => $redirectUri,
            ]);

            if (!isset($response["data"])) {
                return response()->json($response);
            }
            $data = $response["data"];

            $json_response = [
                "correlationId" => $data["correlationId"],
                "transactionId" => $data["transactionId"],
                "vaultLink" => config('services.affinidi_tdk.vault_url') . '/login?request=' . $data["jwt"],
            ];

            return response()->json($json_response);
        } catch (\Exception $e) {
            // Handle or log the error
            error_log('JSON error: ' . $e->getMessage());

            return response()->json(["error" => $e->getMessage()]);
        }
    }

    public function callback(Request $request)
    {
        try {

            $configurationId = $request->input('configurationId');
            $responseCode = $request->input('responseCode');
            $correlationId = $request->input('correlationId');
            $transactionId = $request->input('transactionId');

            $json_response = AffinidiServices::IotaCallback([
                "configurationId" => $configurationId,
                "responseCode" => $responseCode,
                "correlationId" => $correlationId,
                "transactionId" => $transactionId,
            ]);

            return response()->json($json_response);
        } catch (\Exception $e) {
            // Handle or log the error
            error_log('JSON error: ' . $e->getMessage());

            return response()->json(["error" => $e->getMessage()]);
        }
    }
}
