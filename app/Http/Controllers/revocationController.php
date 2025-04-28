<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\AffinidiServices;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr; // Using Laravel's Array helper

class revocationController extends Controller
{
    public function revokeCredential(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'credentialId' => 'required|string', // This is the flowId we need to match
            'revocationReason' => 'required|string',
        ]);

        $credentialIdToFind = $validatedData['credentialId'];
        $revocationReason = $validatedData['revocationReason'];

        $configuration_id = config('services.affinidiCIS.configurationId');
        $project_id = config('services.affinidi_tdk.project_Id');

        Log::info('Configuration ID: ' . $configuration_id);
        Log::info('Project ID: ' . $project_id);
        Log::info('Attempting to find issuance record for credentialId (flowId): ' . $credentialIdToFind);

        // Fetch issuance records response
        $issuanceResponse = AffinidiServices::listIssuanceDataRecords($project_id, $configuration_id, $credentialIdToFind);

        Log::debug('Raw response from listIssuanceDataRecords:', ['data' => $issuanceResponse]); // Keep this for debugging

        // Check if the response structure is as expected and extract the flowData array
        if (!is_array($issuanceResponse) || !isset($issuanceResponse['flowData']) || !is_array($issuanceResponse['flowData'])) {
            Log::error('Unexpected structure or missing flowData in listIssuanceDataRecords response.', ['response' => $issuanceResponse]);
            return response()->json(['error' => 'Unexpected response format from Affinidi service'], 500);
        }

        // Get the actual array of records to search
        $recordsToSearch = $issuanceResponse['flowData'];
        Log::debug('Searching within flowData array.', ['count' => count($recordsToSearch)]);

        // Find the first record where 'flowId' matches the input 'credentialId'
        $matchingRecord = Arr::first($recordsToSearch, function ($record) use ($credentialIdToFind) {
            // Add checks for robustness within the loop
            return is_array($record) && isset($record['flowId']) && $record['flowId'] === $credentialIdToFind;
        });


        // Check if a matching issuance record was found
        if (!$matchingRecord) {
            Log::warning('Issuance record not found for credentialId (flowId): ' . $credentialIdToFind . ' within the flowData.', ['searched_count' => count($recordsToSearch)]);
            return response()->json(['error' => 'Credential ID not found'], 404);
        }

        // Check if the matching record has the 'id' field we need
        if (!isset($matchingRecord['id'])) {
            Log::error('Matching issuance record is missing the "id" field.', ['record' => $matchingRecord]);
            return response()->json(['error' => 'Issuance record format is invalid'], 500);
        }

        // Get the issuance record ID (the 'id' field from the matching record)
        $issuanceRecordId = $matchingRecord['id'];
        Log::info('Found issuance record ID: ' . $issuanceRecordId . ' for flowId: ' . $credentialIdToFind);

        // Prepare input for the revocation API call
        $revoke_credential_input = [
            "issuanceRecordId" => $issuanceRecordId, // This is the 'id' we extracted
            "changeReason" => $revocationReason,
        ];

        Log::info('Revoking credential with input: ', $revoke_credential_input);
        $result = AffinidiServices::revokeCredentials($project_id, $configuration_id, $revoke_credential_input);
        Log::info('Revocation response: ', ['response' => $result]); // Log response as context

        // Check if the revocation failed (adjust based on actual error response structure)
        if (is_array($result) && isset($result['error'])) {
            $errorMessage = is_string($result['error']) ? $result['error'] : 'Unknown error';
            Log::error('Failed to revoke credential: ' . $errorMessage, ['response' => $result]);
            return response()->json(['error' => 'Failed to revoke credential: ' . $errorMessage], 500);
        }
        // Add more specific error checks if needed based on AffinidiServices behavior

        // Return the successful response
        Log::info('Credential revoked successfully for issuanceRecordId: ' . $issuanceRecordId);
        return response()->json($result);
    }
}
