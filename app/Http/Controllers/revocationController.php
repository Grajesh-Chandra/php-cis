<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\AffinidiServices;
use Illuminate\Support\Facades\Log;

class revocationController extends Controller
{
    public function revokeCredential(Request $request)
    {
        $walletId = config('services.affinidi_sign_credentials.walletIdDIDWEB');
        Log::info('Wallet ID: ' . $walletId);
        // Validate the request data
        $request->validate([
            'credentialId' => 'required|string',
            'revocationReason' => 'required|string',
        ]);
        $revoke_credential_input = [
            "issuanceRecordId" => $request->input('credentialId'),
            "changeReason" => $request->input('revocationReason'),
        ];
        $configuration_id = config('services.affinidiCIS.configurationId');
        $project_id = config('services.affinidi_tdk.project_Id');

        $request = $revoke_credential_input;

        Log::info('revoke_credential_input: ', $revoke_credential_input);
        Log::info('Configuration ID: ' . $configuration_id);
        Log::info('Project ID: ' . $project_id);

        $result = AffinidiServices::revokeCredentials($project_id, $configuration_id, $request);
        Log::info('Revocation response: ', $result);
        // Check if the response is valid
        if (isset($result['message'])) {
            return response()->json(['error' => 'Failed to revoke credential: ' . $result['error']], 500);
        }
        // Return the response
        Log::info('Credential revoked successfully: ', $result);

        return response()->json($result);
    }
}
