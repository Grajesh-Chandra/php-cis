<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Providers\AffinidiServices; // Ensure this use statement is present
use Illuminate\Http\JsonResponse;   // Import JsonResponse for type hinting and clarity
use Exception; // Import base Exception class

class verificatonController extends Controller
{
    public function verifyCredentials(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'verifiableCredentials' => 'required|array',
        ]);

        try {
            $credentialsToVerify = [
                'verifiableCredentials' => [$validatedData['verifiableCredentials']]
            ];

            Log::info('Verifying credentials:', $credentialsToVerify);

            $verifiedResponse = AffinidiServices::Verification($credentialsToVerify);

            Log::info('Verification response received:', $verifiedResponse);

            return response()->json($verifiedResponse);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Invalid input provided.', 'errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['message' => 'Verification failed: ' . $e->getMessage()], 500);
        }
    }
}
