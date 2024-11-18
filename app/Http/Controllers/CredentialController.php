<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Exception;
use Affinidi\AffinidiTDK;

class CredentialController extends Controller
{
    public function issueCredential(Request $request)
    {
        try {
            $credentials_request =
                [
                    [
                        "credentialTypeId" => config('services.affinidiCIS.courseCredentialTypeId'),
                        "credentialData" => [
                            "courseID" => "EMP-IT-AUTOMATION-2939302",
                            "course" => [
                                "name" => "IT Automation with Python",
                                "type" => "Professional Certificate",
                                "url" => "",
                                "courseDuration" => "45 Days"
                            ],
                            "learner" => [
                                "name" => "",
                                "email" => "grajesh.c@affinidi.com",
                                "phone" => ""
                            ],
                            "achievement" => [
                                "score" => "100",
                                "grade" => "A"
                            ],
                            "courseMode" => "online",
                            "completionDate" => "08/09/2024"
                        ]
                    ]
                ];


            $apiMethod = '/cis/v1/' . config('services.affinidi_tdk.project_Id') . '/issuance/start';

            $tdk = new AffinidiTDK(
                config('services.affinidi_tdk')
            );

            $data = $tdk->InvokeAPI($apiMethod, [
                'data' => $credentials_request,
                'claimMode' => "TX_CODE"
            ]);

            $json_response = [
                "credentialOfferUri" => $data["credentialOfferUri"],
                "txCode" => $data["txCode"],
                "issuanceId" => $data["issuanceId"],
                "expiresIn" => $data["expiresIn"],
                "vaultLink" => config('services.affinidi_tdk.vault_url') . '/claim?credential_offer_uri=' . $data["credentialOfferUri"],
            ];

            return response()->json($json_response);
        } catch (Exception $e) {
            // Handle or log the error
            error_log('JSON error: ' . $e->getMessage());

            return response()->json(["error" => $e->getMessage()]);
        }
    }
}
